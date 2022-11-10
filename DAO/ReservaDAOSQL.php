<?php
    namespace DAO;

    use DAO\IReservaDAO as IReservaDAO;
    use Models\Estadoreserva as Estadoreserva;
    use Models\Pet as Pet ;
    use Models\Keeper as Keeper ;
    use Models\Reserva as Reserva;
    use Models\Owner ;
    use \Exception as Exception;
use LDAP\Result;
use Models\FechasEstadias;
use Models\Tarjeta;

    class ReservaDAOSQL implements IReservaDAO
    {
        private $connection;
        private $tablename = "reserva";
        private $tableDates = "fechasdisponibles";
        private $tableUser = "users";
        private $tableKeeper = "keeper";
        private $tableOwner = "owner";
        private $tablePet = "pet";
        private $tableCard = "tarjeta";

        public function getLista (){
            return $this->getAll();
        }

        public function Add(Reserva $reserva)
        {
            try
            {
                $keeper = $reserva->getKeeper();
                $pet = $reserva ->getPet();

                $reserva->setEstado(Estadoreserva::Pendiente);

                $query= "INSERT INTO ".$this->tablename." 
                (idKeeper,idFechaDis,idPet,importeReserva,importeTotal,estado) 
                VALUES (:idKeeper,:idFechaDis,:idPet,:importeReserva,:importeTotal,:estado);";
                
                $querySKeeper = "SELECT idKeeper FROM ". $this->tableKeeper .
                " k JOIN " . $this->tableUser. " u ON k.idUser = u.idUser".
                " WHERE u.nombreUser = \"". $keeper->getNombreUser();
                
                $querySPet = "SELECT idPet FROM ". $this->tablePet .
                " p JOIN " . $this->tableOwner. " o ON o.idOwner = p.idOwner".
                " JOIN ". $this->tableUser . "u ON o.idUser = u.idUser".
                " WHERE  u.nombreUser= \"". $keeper->getNombreUser(). "\"
                 AND p.nombre = \"". $pet->getNombre() . "\"";

                $querySFecha = "SELECT f.idFechasDisp FROM ". $this->tableDates .
                " f JOIN " . $this->tableKeeper. " k ON k.idKeeper = f.idKeeper".
                " JOIN ". $this->tableUser . "u ON k.idUser = u.idUser".
                " WHERE  u.nombreUser= \"". $keeper->getNombreUser(). "\"";

                $this->connection = Connection::GetInstance();
                
                $idKeeper = $this->connection->Execute($querySKeeper);
                $idPet = $this->connection->Execute($querySPet);
                $idFecha = $this->connection->Execute($querySFecha);
                $parametersReserva["idKeeper"] = $idKeeper[0]["idKeeper"];
                $parametersReserva["idPet"] = $idPet[0]["idPet"];
                $parametersReserva["idFechasDis"] = $idFecha[0]["idFechasDisp"];
                $parametersReserva["importeReserva"] = $reserva->getImporteReserva();
                $parametersReserva["importeTotal"] = $reserva->getImporteTotal();
                $parametersReserva["estado"] = $reserva->getEstado();
                

                $this->connection->ExecuteNonQuery($query, $parametersReserva);
                
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
        
        public function getALL()
        {
            //Crear un arraylist, pushear como en "obtenerUser" y devolver el array.
            $reservaList = array();
            
            try
            {
                $queryFillKeeper = "SELECT * FROM ". $this->tablename. 
                " r JOIN ". $this->tableKeeper. " k ON k.idKeeper = r.idKeeper".
                " JOIN ". $this->tableUser. " u ON u.idUser = k.idUser";

                $this->connection = Connection::GetInstance();

                $resultReserva = $this->connection->Execute($queryFillKeeper);

                foreach($resultReserva as $value){
                    $reserva = new Reserva(); ///Reserva tiene Owner(Dentro de pet), Keeper, y Pet
                    
                    $reserva->setImporteReserva($value["importeReserva"]);
                    $reserva->setImporteTotal($value["importeTotal"]);
                    $reserva->setEstado($value["estado"]);

                    $queryDatesReserva = "SELECT f.desde,f.hasta FROM ". $this->tablename .
                    "r JOIN fechasdisponibles f ON r.idFechasDis = f.idFechasDisp";
                    $resultDatesReserva = $this->connection->Execute($queryDatesReserva);

                    foreach($resultDatesReserva as $rango){
                        $reserva->setFechadesde($rango["desde"]);
                        $reserva->setFechahasta($rango["hasta"]);   
                    }


                    $owner = new Owner();
                    $petReserva = new Pet();
                    
                    ///Primero Creamos y llenamos el Keeper
                    $keeper = new Keeper($value['nombreUser'],$value ['contrasena'],$value ['tipodeCuenta'],
                    $value ['tipoMascota'],$value ['remuneracion'],$value ['nombre'], $value ['apellido'],$value ['DNI'],
                    $value ['telefono']);
                   
                    $queryDates = "SELECT * FROM ". $this->tableKeeper . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper"
                    . "WHERE d.idKeeper= (SELECT k.idKeeper FROM keeper k JOIN user u ON k.idUser = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser() . "\")";
                    
                    $result = $this->connection->Execute($queryDates);
                    if($result){
                        foreach($result as $fecha){
                            $fechaResultado = new FechasEstadias($fecha["desde"],$fecha["hasta"]);
                            $keeper->agregarFecha($fechaResultado);
                        }
                    }
                    
                    $reserva->setKeeper($keeper);

                    ///LLenamos el Owner de Nuestro Pet
                    $queryFillOwner = "SELECT u.nombreUser, u.contrasena, u.tipoDeCuenta,u.nombre,u.apellido,u.dni,u.telefono FROM ". $this->tablename. 
                    " r JOIN ". $this->tablePet. " p ON p.idPet = r.idPet".
                    " JOIN ". $this->tableOwner. " o ON p.idOwner = o.idOwner".
                    " JOIN ". $this->tableUser . " u ON u.idUser = o.idUser";

                    $resultOwner = $this->connection->Execute($queryFillOwner);

                    if($resultOwner){
                        foreach($resultOwner as $value){
                            $owner -> setNombreUser($value["nombreUser"]);
                            $owner -> setContrasena($value["contrasena"]);
                            $owner -> setTipodecuenta($value["tipoDeCuenta"]);
                            $owner -> setNombre($value["nombre"]);
                            $owner -> setApellido($value["apellido"]);
                            $owner -> setDni($value["dni"]);
                            $owner -> setTelefono($value["telefono"]);
                        }
                    }

                    $queryTarjeta = "SELECT * FROM ". $this->tableCard . " WHERE "." idOwner = 
                    (SELECT o.idOwner FROM Owner o 
                    JOIN user u ON u.idUser = o.idUser 
                    WHERE u.nombreUser = \"".$owner->getNombreUser()."\")";
                    
                    ///Le llenamos las tarjetas al owner
                    $resultOwnerTarjeta = $this->connection->Execute($queryTarjeta);

                    foreach($resultOwnerTarjeta as $tarjeta){
                        $tarjeta = new Tarjeta();
                        $tarjeta->setNumero($tarjeta["numero"]);
                        $tarjeta->setNombre($tarjeta["nombre"]);
                        $tarjeta->setFechaVenc($tarjeta["fechaVenc"]);
                        $tarjeta->setCodigo($tarjeta["codigo"]);
                        $tarjeta->setApellido($tarjeta["Apellido"]);
                        $owner->agregarTarjeta($tarjeta);
                    }

                    ///Conseguimos y le llenamos los pets al owner

                    $queryPetOwner = "SELECT * FROM ". $this->tablePet . " WHERE "." idOwner = 
                    (SELECT o.idOwner FROM Owner o 
                    JOIN user u ON u.idUser = o.idUser 
                    WHERE u.nombreUser = \"".$owner->getNombreUser()."\")";


                    $resultOwnerPets = $this->connection->Execute($queryPetOwner);

                    foreach($resultOwnerPets as $pet){
                        $pet = new Pet();
                        $pet->setNombre($pet["nombre"]);
                        $pet->setRaza($pet["raza"]);
                        $pet->setTamano($pet["tamano"]);
                        $pet->setImg($pet["imagen"]);
                        $pet->setPlanVacunacion($pet["planVacunacion"]);
                        $pet->setObservacionesGrals($pet["observacionesGrals"]);
                        $pet->setVideo($pet["video"]);
                        $pet->setOwner($owner); ///El owner a su vez tiene un pet
                        $owner->agregarPet($pet);
                    }

                    ///Creamos y llenamos el pet de LA RESERVA
                    $queryFillPet = "SELECT * FROM ". $this->tablename. 
                    " r JOIN ". $this->tablePet. " p ON p.idPet = r.idPet";

                    $resultPet = $this->connection->Execute($queryFillPet);

                    foreach($resultPet as $pet){
                        $petReserva->setNombre($pet["nombre"]);
                        $petReserva->setRaza($pet["raza"]);
                        $petReserva->setTamano($pet["tamano"]);
                        $petReserva->setImg($pet["imagen"]);
                        $petReserva->setPlanVacunacion($pet["planVacunacion"]);
                        $petReserva->setObservacionesGrals($pet["observacionesGrals"]);
                        $petReserva->setVideo($pet["video"]);
                        $petReserva->setOwner($owner); ///Le seteamos el owner que llenamos arriba
                    }

                    $reserva->setPet($petReserva);


                    array_push($reservaList,$reserva);
                }


            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
            return $reservaList;

        }


        public function reservasAceptadas(){
            $reservasAceptadas = array(); 

            $query = "SELECT * FROM ". $this->tablename . "WHERE estado = \"".Estadoreserva::Aceptada."\"";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach($resultSet as $reservas){
                $reserva = new Reserva(); ///Reserva tiene Owner(Dentro de pet), Keeper, y Pet
                    
                    $reserva->setImporteReserva($reservas["importeReserva"]);
                    $reserva->setImporteTotal($reservas["importeTotal"]);
                    $reserva->setEstado($reservas["estado"]);

                    $queryDatesReserva = "SELECT f.desde,f.hasta FROM ". $this->tablename .
                    "r JOIN fechasdisponibles f ON r.idFechasDis = f.idFechasDisp";
                    $resultDatesReserva = $this->connection->Execute($queryDatesReserva);

                    foreach($resultDatesReserva as $rango){
                        $reserva->setFechadesde($rango["desde"]);
                        $reserva->setFechahasta($rango["hasta"]);   
                    }


                    $owner = new Owner();
                    $petReserva = new Pet();
                    
                    ///Primero Creamos y llenamos el Keeper
                    $keeper = new Keeper($reservas['nombreUser'],$reservas ['contrasena'],$reservas ['tipodeCuenta'],
                    $reservas ['tipoMascota'],$reservas ['remuneracion'],$reservas ['nombre'], $reservas ['apellido'],$reservas ['DNI'],
                    $reservas ['telefono']);
                   
                    $queryDates = "SELECT * FROM ". $this->tableKeeper . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper"
                    . "WHERE d.idKeeper= (SELECT k.idKeeper FROM keeper k JOIN user u ON k.idUser = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser() . "\")";
                    
                    $result = $this->connection->Execute($queryDates);
                    if($result){
                        foreach($result as $fecha){
                            $fechaResultado = new FechasEstadias($fecha["desde"],$fecha["hasta"]);
                            $keeper->agregarFecha($fechaResultado);
                        }
                    }
                    
                    $reserva->setKeeper($keeper);

                    ///LLenamos el Owner de Nuestro Pet
                    $queryFillOwner = "SELECT u.nombreUser, u.contrasena, u.tipoDeCuenta,u.nombre,u.apellido,u.dni,u.telefono FROM ". $this->tablename. 
                    " r JOIN ". $this->tablePet. " p ON p.idPet = r.idPet".
                    " JOIN ". $this->tableOwner. " o ON p.idOwner = o.idOwner".
                    " JOIN ". $this->tableUser . " u ON u.idUser = o.idUser";

                    $resultOwner = $this->connection->Execute($queryFillOwner);

                    if($resultOwner){
                        foreach($resultOwner as $value){
                            $owner -> setNombreUser($value["nombreUser"]);
                            $owner -> setContrasena($value["contrasena"]);
                            $owner -> setTipodecuenta($value["tipoDeCuenta"]);
                            $owner -> setNombre($value["nombre"]);
                            $owner -> setApellido($value["apellido"]);
                            $owner -> setDni($value["dni"]);
                            $owner -> setTelefono($value["telefono"]);
                        }
                    }

                    $queryTarjeta = "SELECT * FROM ". $this->tableCard . " WHERE "." idOwner = 
                    (SELECT o.idOwner FROM Owner o 
                    JOIN user u ON u.idUser = o.idUser 
                    WHERE u.nombreUser = \"".$owner->getNombreUser()."\")";
                    
                    ///Le llenamos las tarjetas al owner
                    $resultOwnerTarjeta = $this->connection->Execute($queryTarjeta);

                    foreach($resultOwnerTarjeta as $tarjeta){
                        $tarjeta = new Tarjeta();
                        $tarjeta->setNumero($tarjeta["numero"]);
                        $tarjeta->setNombre($tarjeta["nombre"]);
                        $tarjeta->setFechaVenc($tarjeta["fechaVenc"]);
                        $tarjeta->setCodigo($tarjeta["codigo"]);
                        $tarjeta->setApellido($tarjeta["Apellido"]);
                        $owner->agregarTarjeta($tarjeta);
                    }

                    ///Conseguimos y le llenamos los pets al owner

                    $queryPetOwner = "SELECT * FROM ". $this->tablePet . " WHERE "." idOwner = 
                    (SELECT o.idOwner FROM Owner o 
                    JOIN user u ON u.idUser = o.idUser 
                    WHERE u.nombreUser = \"".$owner->getNombreUser()."\")";


                    $resultOwnerPets = $this->connection->Execute($queryPetOwner);

                    foreach($resultOwnerPets as $pet){
                        $pet = new Pet();
                        $pet->setNombre($pet["nombre"]);
                        $pet->setRaza($pet["raza"]);
                        $pet->setTamano($pet["tamano"]);
                        $pet->setImg($pet["imagen"]);
                        $pet->setPlanVacunacion($pet["planVacunacion"]);
                        $pet->setObservacionesGrals($pet["observacionesGrals"]);
                        $pet->setVideo($pet["video"]);
                        $pet->setOwner($owner); ///El owner a su vez tiene un pet
                        $owner->agregarPet($pet);
                    }

                    ///Creamos y llenamos el pet de LA RESERVA
                    $queryFillPet = "SELECT * FROM ". $this->tablename. 
                    " r JOIN ". $this->tablePet. " p ON p.idPet = r.idPet";

                    $resultPet = $this->connection->Execute($queryFillPet);

                    foreach($resultPet as $pet){
                        $petReserva->setNombre($pet["nombre"]);
                        $petReserva->setRaza($pet["raza"]);
                        $petReserva->setTamano($pet["tamano"]);
                        $petReserva->setImg($pet["imagen"]);
                        $petReserva->setPlanVacunacion($pet["planVacunacion"]);
                        $petReserva->setObservacionesGrals($pet["observacionesGrals"]);
                        $petReserva->setVideo($pet["video"]);
                        $petReserva->setOwner($owner); ///Le seteamos el owner que llenamos arriba
                    }

                    $reserva->setPet($petReserva);

                    array_push($reservasAceptadas,$reserva);
            }

            return $reservasAceptadas;
        }


        public function obtenerUser($username){
            $theKeeper = null;

            try{
                
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUserr = u.idUser ". "WHERE u.nombreUser = \"". $username ."\"";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);

                foreach ($resultSet as $row)
                {            
                    $theKeeper = new Keeper($row["nombreUser"],$row["contrasena"],$row["tipoDeCuenta"],$row["tipoMascota"],$row["remuneracion"],$row["nombre"],$row["apellido"],$row["dni"],$row["telefono"]);
                    
                }

            }catch(Exception $ex){
                throw $ex;
            }
            
            return $theKeeper;
        }

        public function comprobarLogin($username, $contrasena){
            $user = null;

            try{
                
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUserr = u.idUser WHERE u.nombreUser = \"". $username ."\"" ." AND u.contrasena = \"" .$contrasena."\"";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);

                if($resultSet){
                    foreach ($resultSet as $row)
                    {            
                      $user = new Keeper($row["nombreUser"],$row["contrasena"],$row["tipoDeCuenta"],$row["tipoMascota"],$row["remuneracion"],$row["nombre"],$row["apellido"],$row["dni"],$row["telefono"]);
                    
                    }
                }
                
            }catch(Exception $ex){
                throw $ex;
            }
            
            return $user;
        }

        public function agregarFecha(FechasEstadias $estadia, $username){
                $desde = $estadia -> getDesde();
                $hasta = $estadia -> getHasta();
                //$desde = date_parse_from_format('Y-m-d',$desde);
                //$desde = date_parse_from_format('Y-m-d',$hasta);
                $dateDesde = date_create($estadia -> getDesde());
                $dateHasta = date_create($estadia -> getHasta());
                

            try{
                $query = "INSERT INTO ". $this->tableDates . " (desde,hasta,idKeeper) VALUES " . "(\"".date_format($dateDesde,"Y/m/d")."\",\"".date_format($dateHasta,"Y/m/d")."\",".
                "(SELECT k.idKeeper FROM keeper k JOIN users u on k.idUserr = u.idUser WHERE u.nombreUser = \"". $username . "\"))";

                $this->connection = Connection::GetInstance();
                $this->connection->Execute($query);

                
            } catch (Exception $ex){
                throw $ex;
            }
            
        }

        public function verificarRangos ($desde , $hasta  ,$userName){
            $verificar = null ;

            $fecDesde =  date_create($desde);
            $fecHasta =  date_create($hasta);
             ///Modificar mañana que compruebe si esta en la base, y en ese caso retornar la fecha
            try
            {
                $queryFecha = "SELECT * FROM ". $this->tableDates.
                " f JOIN keeper k ON f.idKeeper = k.idKeeper
                JOIN users u ON k.idUserr = u.idUser ".
                " WHERE (f.desde = \"". date_format($fecDesde,"Y/m/d")."\") 
                AND (f.hasta= \"".date_format($fecHasta,"Y/m/d")."\")". 
                " AND u.nombreUser = \"".$userName."\"" ;

                $this->connection = Connection::GetInstance();

                $resultUser = $this->connection->Execute($queryFecha);
                if($resultUser){
                        foreach ($resultUser as $fecha){
                        $estadia = new FechasEstadias($fecha["desde"],$fecha["hasta"]);
                        //var_dump($estadia);
                        //var_dump($desde);
                        //var_dump($hasta);
                        if (($desde >= $estadia->getDesde() && $hasta <= $estadia->getHasta()) 
                        || ($desde < $estadia->getDesde () &&  $hasta > $estadia->getHasta()) 
                        || ($desde>=$estadia->getDesde() && $desde<=$estadia->getHasta() && $hasta> $estadia->getHasta() )){
                            $verificar = $estadia;
                        }
                        } 
                }

            }
            catch (Exception $ex)
            {
                throw $ex;
            }


            return $verificar;

        }

        public function verificarFechadeldia ($desde , $hasta){
            $date = date("Y-m-d");

            if ( $hasta >= $date && $desde>= $date){
                return true;
            }
            else {
                return false ;
            }
        }

        public function quitarFecha ($username , FechasEstadias $fecha){
            $fecDesde =  date_create($fecha->getDesde());
            $fecHasta =  date_create($fecha->getHasta());

            try
            {
                $query="DELETE FROM ". $this->tableDates. " WHERE desde = \"". date_format($fecDesde,"Y/m/d")."\" AND hasta = \"". date_format($fecHasta,"Y/m/d"). "\""
                ."AND idKeeper = ". "(SELECT k.idKeeper from keeper k JOIN users u ON u.idUser = k.idUserr WHERE u.nombreUser = \"". $username."\")";
            
                $this->connection = Connection::GetInstance();

                $this->connection->Execute($query);    
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
        }

        public function buscarEstadias ($nombreUser){
            $estadiasLista = array ();

            try
            {
                $query= "SELECT * FROM ". $this->tableDates. 
                " f JOIN keeper k ON f.idKeeper = k.idKeeper
                JOIN users u ON k.idUserr = u.idUser
                WHERE u.nombreUser = \"". $nombreUser. "\"";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);   

                foreach($resultSet as $fecha){
                    $date = new FechasEstadias($fecha["desde"],$fecha["hasta"]);
                    array_push($estadiasLista,$date);
                }

            }
            catch (Exception $ex)
            {
                throw $ex;
            }


            return $estadiasLista;


        }
    }
       
    
?>