<?php
    namespace DAO;

    use \Exception as Exception;
    use Models\Keeper as Keeper ;
    use DAO\OwnerDao as OwnerDao;
    use Models\FechasEstadias as FechasEstadias;
    use Models\Reserva;

    class KeeperDAOSQL implements IKeeperDAO
    {
        private $connection;
        private $tablename = "keeper";
        private $tableDates = "fechasdisponibles";
        private $tableUser = "user";

        public function addKeeper(Keeper $keeper)
        {
          
         /*
            $queryUser =  "INSERT INTO " . $this-> tableUser. " (nombreUser, contrasena,tipoDeCuenta,nombre,apellido,dni,telefono)
                                                                VALUES (:nombreUser, :contrasena,:tipoDeCuenta,:nombre,:apellido,:dni,:telefono)";
            $queryKeeper= "INSERT INTO ".$this->tablename." (tipoMascota,remuneracion,idUser) VALUES (:tipoMascota,:remuneracion,:idUserr);";
            
            $queryFechas= "INSERT INTO ". $this->tableDates . " (desde,hasta,idKeeper) VALUES (:desde, :hasta, :idKeeper) ";

            $thirdQuery = "SELECT idUser FROM ". $this->tableUser . " WHERE "." nombreUser = \"". $keeper->getNombreUser()."\"";
            
            $fourthQuery = "SELECT k.idKeeper FROM ". $this->tablename . " k LEFT JOIN " . $this->tableUser." u ON k.idUser = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser()."\"";
            

            $queryKeeper= "INSERT INTO ".$this->tablename." (tipoMascota,remuneracion,idUser) VALUES (:tipoMascota,:remuneracion,:idUserr);";

            $thirdQuery = "SELECT idUser FROM ". $this->tableUser . " WHERE "." nombreUser = \"". $keeper->getNombreUser()."\"";

            */

            $queryUser = "Call add_user (?,?,?,?,?,?,?)";
            
            $parametersUser["nombreUser"] = $keeper->getNombreUser();
            $parametersUser["contrasena"] = $keeper->getContrasena();
            $parametersUser["tipoDeCuenta"] = $keeper->getTipodecuenta();
            $parametersUser["nombre"] = $keeper->getNombre();
            $parametersUser["apellido"] = $keeper->getApellido();
            $parametersUser["dni"] = $keeper->getDni();
            $parametersUser["telefono"] = $keeper->getTelefono();
            
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($queryUser, $parametersUser , queryType::StoredProcedure);

            /////Keeper como tal
            $queryKeeper = "Call add_keeper (?,?,?)";
            $queryUser  = "CALL buscar_user (?)";
            $user = array(); 
            $user["nombreUser"] = $keeper->getNombreUser();

            $tiposMascota = $keeper->getTipo();
            foreach ($tiposMascota as $tipo){
                $parametersKeeper["tipoMascota"] = $tipo;
            }
  
            $parametersKeeper["remuneracion"] = $keeper->getRemuneracion();
            $result = $this->connection->Execute($queryUser , $user , queryType::StoredProcedure);

            foreach ($result as $row){
                $parametersKeeper["idUser"] = $row["idUser"];
            }

            $this->connection->ExecuteNonQuery($queryKeeper, $parametersKeeper , queryType::StoredProcedure);
/*

                ///Conseguimos el user para el que llenaremos fechas:
                $idUser = $this->connection->Execute($fourthQuery);

                if($keeper -> getFechas() != null){
                    foreach ($keeper->getFechas() as $estadia){
                    $parametersFechas['desde']=$estadia->getDesde();
                    $parametersFechas['hasta']=$estadia->getHasta(); 
                    $parametersFechas['idKeeper']=$idUser["idKeeper"][0];
                    $this->connection->ExecuteNonQuery($queryFechas, $parametersFechas);
                    }
                }
                */
            
      
        }



        public function getALL()
        {
            //Crear un arraylist, pushear como en "obtenerUser" y devolver el array.
            $keeperList = array();
            
            try
            {
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUser = u.idUser ";

                $queryDates = "SELECT * FROM ". $this->tablename . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper";
                


                $this->connection = Connection::GetInstance();

                $resultUser = $this->connection->Execute($query);

                foreach($resultUser as $value){
                    $keeper = new Keeper($value['nombreUser'],$value ['contrasena'],$value ['tipodeCuenta'],
                    $value ['tipoMascota'],$value ['remuneracion'],$value ['nombre'], $value ['apellido'],$value ['DNI'],
                    $value ['telefono']);

                    $queryDates = "SELECT * FROM ". $this->tablename . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper"
                    . "WHERE d.idKeeper= (SELECT k.idKeeper FROM keeper k JOIN user u ON k.idUser = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser() . "\")";
                    
                    $result = $this->connection->Execute($queryDates);
                    if($result){
                        foreach($result as $fecha){
                            $fechaResultado = new FechasEstadias($fecha[0]["desde"],$fecha[0]["hasta"]);
                            $keeper->agregarFecha($fechaResultado);
                        }
                    }


                    array_push($keeperList,$keeper);
                }


            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
            return $keeperList;

        }

        public function obtenerUser($username){
            $theKeeper = null;

            try{
                
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUser = u.idUser ". "WHERE u.nombreUser = \"". $username ."\"";

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
                
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUser = u.idUser WHERE u.nombreUser = \"". $username ."\"" ." AND u.contrasena = \"" .$contrasena."\"";

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
                "(SELECT k.idKeeper FROM keeper k JOIN user u on k.idUser = u.idUser WHERE u.nombreUser = \"". $username . "\"))";

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
                JOIN user u ON k.idUser = u.idUser ".
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
                ."AND idKeeper = ". "(SELECT k.idKeeper from keeper k JOIN user u ON u.idUser = k.idUser WHERE u.nombreUser = \"". $username."\")";
            
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
                JOIN user u ON k.idUser = u.idUser
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