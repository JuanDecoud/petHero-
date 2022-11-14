<?php

    namespace DAOSQL;
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

    class ReservaDAO implements IReservaDAO
    {
        private $connection;
        private $tablename = "reserva";
        private $tableDates = "fechasdisponibles";
        private $tableUser = "user";
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

                /*
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
                */

                $pet = $reserva->getPet();
                $owner = $pet->getOwner();
                $keeper = $reserva->getKeeper();
    
                // las querys que se van ejecutar 
                $query = "CALL add_reserva (?,?,?,?,?)";
                $queryKeeper = "CALL buscar_keeper(?)";
                $queryOwner = "CALL buscar_owner(?)";
                $queryPet = "CALL buscarPetId(?,?)";
                $queryReserva = "CALL buscaridReserva(?)";
    
         
               $this->connection= Connection::GetInstance();
    
               //PARAMETROS-------------------------------
    
               $parametros = array ();
               $parametrosMascota= array() ;

               // busco el id del keeper 
                
                $keeperName['nombreUser'] = $keeper->getNombreUser();
                $result =  $this->connection->Execute($queryKeeper ,$keeperName,queryType::StoredProcedure);
                foreach ($result as $fila){
                    $parametros['idKeeper'] = $fila['idKeeper'] ;
                }

                // busco el id del owner 
                $ownerNombre1['nombreUser'] = $owner->getNombreUser() ;
                $resultadoOwner = $this->connection->Execute  ($queryOwner , $ownerNombre1 , QueryType::StoredProcedure);
                
                $parametrosMascota['nombrePet'] = $pet->getNombre();
                foreach ($resultadoOwner as $fila1){
                    $parametrosMascota['idOwner'] = $fila1['idOwner'] ;
                }

                //buscar el id de la mascota
                $resultadoMascota = $this->connection->Execute($queryPet , $parametrosMascota , QueryType::StoredProcedure);

                foreach ($resultadoMascota as $row){
                    $parametros['idPet']=$row[0];
                }
    
                $parametros ['importeReserva'] = $reserva->getImporteReserva();
                $parametros ['importeTotal'] = $reserva->getImporteTotal();
                $parametros['estado'] = Estadoreserva::Pendiente;
    
                $this->connection->ExecuteNonQuery($query,$parametros,queryType::StoredProcedure);

    
                //guardo los dias seleccionados correspondientes al rango que figura en sistema
                $diasSeleccionados = $reserva->getDias();
                $this->guardarDias($diasSeleccionados , $parametros['idKeeper'] , $parametros['idPet']);
                
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

                    $idKeeper = $value['idKeeper'];
                    $idPet = $value ['idPet'];
                    $idReserva = $value['idReserva'];

                    $reserva = new Reserva(); ///Reserva tiene Owner(Dentro de pet), Keeper, y Pet
                    $reserva->setImporteReserva($value["importeReserva"]);
                    $reserva->setImporteTotal($value["importeTotal"]);
                    $reserva->setEstado($value["estado"]);

                    $owner = new Owner();
                    $petReserva = new Pet();
                    
                    ///Primero Creamos y llenamos el Keeper
                    $keeper = new Keeper($value['nombreUser'],$value ['contrasena'],$value ['tipoDeCuenta']
                   ,$value ['remuneracion'],$value ['nombre'], $value ['apellido'],$value ['dni'],
                    $value ['telefono']);                   
                    
                    $reserva->setKeeper($keeper);

                    ///LLenamos el Owner de Nuestro Pet
                    $queryFillOwner = "SELECT u.nombreUser FROM ". $this->tablename. 
                    " r JOIN ". $this->tablePet. " p ON p.idPet = r.idPet".
                    " JOIN ". $this->tableOwner. " o ON p.idOwner = o.idOwner".
                    " JOIN ". $this->tableUser . " u ON u.idUser = o.idUser";

                    $resultOwner = $this->connection->Execute($queryFillOwner);

                    if($resultOwner){
                        foreach($resultOwner as $value){
                            $owner -> setNombreUser($value["nombreUser"]);
                        }
                    }             

                    ///Conseguimos y le llenamos los pets al owner

                    $queryPetOwner = "SELECT * FROM ". $this->tablePet . " WHERE "." idOwner = 
                    (SELECT o.idOwner FROM Owner o 
                    JOIN user u ON u.idUser = o.idUser 
                    WHERE u.nombreUser = \"".$owner->getNombreUser()."\")";



                    ///Creamos y llenamos el pet de LA RESERVA
                    $queryFillPet = "SELECT * FROM ". "pet";
                  

                    $resultPet = $this->connection->Execute($queryFillPet);

                    foreach($resultPet as $pet){
                        $petReserva->setNombre($pet[1]);
                        $petReserva->setRaza($pet[2]);
                        $petReserva->setTamano($pet[3]);
                        $petReserva->setImg($pet[4]);
                        $petReserva->setPlanVacunacion($pet[5]);
                        $petReserva->setObservacionesGrals($pet[6]);
                        $petReserva->setVideo($pet[7]);
                        $petReserva->setOwner($owner); ///Le seteamos el owner que llenamos arriba
                    }

         
                    $parametro['idReserva'] = $idReserva;
    
                    $buscarFechas = "Call buscar_diasReserva(?)";
                    $diasEncontrados = $this->connection->Execute($buscarFechas ,$parametro ,QueryType::StoredProcedure);
                    $dias = array ();
                    foreach ($diasEncontrados as $row){
                        array_push($dias, $row[0]);
                    } 
                    $reserva->setDias($dias);
                    
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
                $reserva = new Reserva();
                $reserva = $this->devolverReserva($reservas);
                
                array_push($reservasAceptadas,$reserva);
            }

            return $reservasAceptadas;
        }


        private function devolverReserva($reservas){
            $reserva = new Reserva(); ///Reserva tiene Owner(Dentro de pet), Keeper, y Pet
            
            $reserva->setImporteReserva($reservas["importeReserva"]);
            $reserva->setImporteTotal($reservas["importeTotal"]);
            $reserva->setEstado($reservas["estado"]);

            $queryDatesReserva = "SELECT f.desde,f.hasta FROM ". $this->tablename .
            "r JOIN fechasdisponibles f ON r.idFechasDis = f.idFechasDisp";
            $resultDatesReserva = $this->connection->Execute($queryDatesReserva);

            foreach($resultDatesReserva as $rango){
                //$reserva->setFechadesde($rango["desde"]);
                //$reserva->setFechahasta($rango["hasta"]);   
            }
        
        

            $owner = new Owner();
            $petReserva = new Pet();
            
            ///Primero Creamos y llenamos el Keeper
            $keeper = new Keeper($reservas['nombreUser'],$reservas ['contrasena'],$reservas ['tipodeCuenta'],
            $reservas ['tipoMascota'],$reservas ['remuneracion'],$reservas ['nombre'], $reservas ['apellido'],$reservas ['DNI'],
            $reservas ['telefono']);
           
            $queryDates = "SELECT * FROM ". $this->tableKeeper . 
            " k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper"
            . "WHERE d.idKeeper= 
            (SELECT k.idKeeper FROM 
            keeper k JOIN user u ON k.idUser = u.idUser 
            WHERE u.nombreUser = \"".$keeper->getNombreUser() . "\")";
            
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
            return $reserva;
        }

        public function fechasRango ($desde , $hasta , $nombreKeeper){
            $arregloDias= array ();
            try
            {
                
                $querydiasreservados = "Call buscarDias (?,?,?)" ;
                $parametrosDias ['desde'] = $desde ;
                $parametrosDias ['hasta'] = $hasta ;
                $parametrosDias ['nombreUser'] = $nombreKeeper ;

                $this->connection = Connection::GetInstance();

                $dias = $this->connection->Execute($querydiasreservados , $parametrosDias , queryType::StoredProcedure);
                foreach ($dias as $fila){
                    array_push($arregloDias , $fila[0]);
                    
                }
            }
            catch (Exception $ex)
            {
                throw $ex ;
            }

            $fecha= $desde; 
            $array_fechas = array ();
            while ($fecha <= $hasta){
                array_push ($array_fechas , $fecha);
                $fecha=date("Y-m-d",strtotime($fecha."+ 1 days")); 
            }
             $diasDisponibles = array_diff($array_fechas , $arregloDias);
           
            return $diasDisponibles;
        }

        private function guardarDias ($dias , $idKeeper , $idmascota ){
            $result = null ;
            $parametro ['idRango'] = null;

            try
            {
                $buscarRango = "CALL buscaridRango(?,?)";
                $guardarDias = "CALL guardarDias(?,?,?)";
                $buscarIdreserva = "CALL buscar_reservaiD(?,?)";
                

                // parametros para buscar el rango 
                $dia['fecha'] = $dias[0];
                $dia['idKeeper'] = $idKeeper ;
                var_dump($dia);

                // obtengo el id del rango y lo guardo
                $this->connection = Connection::GetInstance();
                $result =$this->connection->Execute($buscarRango , $dia , queryType::StoredProcedure);
                foreach ($result as $row){
                    $parametro['idRango'] = $row[0];
                }

                //busco el id de la reserva

                $reserva['idKeeper'] = $idKeeper ;
                $reserva['idPet'] = $idmascota ;
                $resultadoReserva =$this->connection->Execute($buscarIdreserva,$reserva,QueryType::StoredProcedure);
                foreach ($resultadoReserva as $row){
                    $parametro['idReserva'] = $row[0];
                }

               foreach ($dias as $fecha){
                $parametro['fecha'] = $fecha ;
                $this->connection->ExecuteNonQuery($guardarDias , $parametro , queryType::StoredProcedure);
               }
               
            }
            catch (Exception $ex)
            {
                throw $ex ;
            }
        }

        public function buscarReservaxEstado ($lista,$nombreUser , $estado ){
           
            $listaReservas = array ();
            foreach($lista as $reserva){
                
                $pet = $reserva->getPet();
                $owner = $pet->getOwner();
                if ($owner->getNombreUser() == $nombreUser && $pet->getNombre() 
                && $reserva->getEstado () == $estado){
                    array_push($listaReservas , $reserva);
                }
            }
            return $listaReservas;
        }

        
        public function buscarReservaxEstadoKeeper ($lista,$nombreUser , $estado ){
     
           
            $listaReservas = array ();
         
            foreach($lista as $reserva){
                
                $pet =  $reserva->getPet();
                $keeper = $reserva->getKeeper();
                if ($keeper->getNombreUser() == $nombreUser && $pet->getNombre() 
                && $reserva->getEstado () == $estado){
                    array_push($listaReservas , $reserva);
                }
            }
            return $listaReservas;
        }

        public function cambiarEstado ( $owner , $pet, $nombreUsuario ,$estado){
            
            try
            {
                $query = "CALL buscarPetId_Nombre(?,?)";
                $parametros ['nombrePet'] = $pet ;
                $parametros ['nombreUser'] = $owner ;
                $this->connection = Connection::GetInstance() ;

                $result  = $this->connection->Execute($query,$parametros ,QueryType::StoredProcedure);
                $idPet = null;
                foreach ($result as $row){
                    
                    $idPet = $row['idPet'];
                }

                $cambiarEstado = "Call cambiarEstado(?,?,?)";

                $parametrosEstado ['idPet'] = $idPet;
                $parametrosEstado['nombreUser'] = $nombreUsuario;
                $parametrosEstado['estado'] = $estado;

                $this->connection->ExecuteNonQuery($cambiarEstado , $parametrosEstado , QueryType::StoredProcedure);

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }
                       
          
        }

        public function borrarReserva ($owner , $pet , $nombreUsuario){

                        
            try
            {
                $query = "CALL buscarPetId_Nombre(?,?)";
                $keeper = "CALL buscar_Keeper(?)";
                $buscarReserva = "Call buscar_reservaiD(?,?)";
                $eliminardiasReserva = "Call eliminar_diasReserva(?)";
                $eliminarReserva = "CALL eliminar_Reserva(?)";

                $parametros ['nombrePet'] = $pet ;
                $parametros ['nombreUser'] = $owner ;
                $this->connection = Connection::GetInstance() ;

                $result  = $this->connection->Execute($query,$parametros ,QueryType::StoredProcedure);
                $idPet = null;
                foreach ($result as $row){
                    $idPet = $row['idPet'];
                }

                $parametroKeeper['nombreUser'] = $nombreUsuario;
                $resultadokeeper = $this->connection->Execute($keeper , $parametroKeeper , QueryType::StoredProcedure);
                $idKeeper = null ;
                foreach ($resultadokeeper as $row){
                    $idKeeper = $row['idKeeper'];
                }


                $reserva ['idKeeper'] = $idKeeper;
                $reserva ['idPet'] = $idPet;
                

                $resultadoReserva = $this->connection->Execute($buscarReserva ,$reserva,QueryType::StoredProcedure);
                $idReserva['idReserva'] = null ;
                foreach ($resultadoReserva as $row){
                    $idReserva['idReserva']  = $row['idReserva'];
                }

                $this->connection->ExecuteNonQuery($eliminardiasReserva , $idReserva ,QueryType::StoredProcedure);
                $this->connection->ExecuteNonQuery($eliminarReserva ,$idReserva , QueryType::StoredProcedure );

            }
            catch (Exception $ex)
            {
                
                throw $ex ;
            }

        }


    

    }


    
    
?>