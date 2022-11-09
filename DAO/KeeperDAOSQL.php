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
        private $tableUser = "users";

        public function addKeeper(Keeper $keeper)
        {
            try
            {

                $queryUser =  "INSERT INTO " . $this-> tableUser. " (nombreUser, contrasena,tipoDeCuenta,nombre,apellido,dni,telefono)
                                                                    VALUES (:nombreUser, :contrasena,:tipoDeCuenta,:nombre,:apellido,:dni,:telefono)";
                $queryKeeper= "INSERT INTO ".$this->tablename." (tipoMascota,remuneracion,idUserr) VALUES (:tipoMascota,:remuneracion,:idUserr);";
                
                $queryFechas= "INSERT INTO ". $this->tableDates . " (desde,hasta,idKeeper) VALUES (:desde, :hasta, :idKeeper) ";

                $thirdQuery = "SELECT idUser FROM ". $this->tableUser . " WHERE "." nombreUser = \"". $keeper->getNombreUser()."\"";
                
                $fourthQuery = "SELECT k.idKeeper FROM ". $this->tablename . " k LEFT JOIN " . $this->tableUser." u ON k.idUserr = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser()."\"";
                
                
                $parametersUser["nombreUser"] = $keeper->getNombreUser();
                $parametersUser["contrasena"] = $keeper->getContrasena();
                $parametersUser["tipoDeCuenta"] = $keeper->getTipodecuenta();
                $parametersUser["nombre"] = $keeper->getNombre();
                $parametersUser["apellido"] = $keeper->getApellido();
                $parametersUser["dni"] = $keeper->getDni();
                $parametersUser["telefono"] = $keeper->getTelefono();
                
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($queryUser, $parametersUser);

                /////Keeper como tal
                $tiposMascota = $keeper->getTipo();
                $string = "";
                foreach($tiposMascota as $tipo){
                    $string .= $tipo;
                    $string .= " ";
                }
                $parametersKeeper["tipoMascota"] = $string;
                $parametersKeeper["remuneracion"] = $keeper->getRemuneracion();
                $result = $this->connection->Execute($thirdQuery);
                $parametersKeeper["idUserr"] = $result[0]["idUser"];

                $this->connection->ExecuteNonQuery($queryKeeper, $parametersKeeper);


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
                
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function getALL()
        {
            //Crear un arraylist, pushear como en "obtenerUser" y devolver el array.
            $keeperList = array();
            
            try
            {
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUserr = u.idUser ";

                $queryDates = "SELECT * FROM ". $this->tablename . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper";
                


                $this->connection = Connection::GetInstance();

                $resultUser = $this->connection->Execute($query);

                foreach($resultUser as $value){
                    $keeper = new Keeper($value['nombreUser'],$value ['contrasena'],$value ['tipodeCuenta'],
                    $value ['tipoMascota'],$value ['remuneracion'],$value ['nombre'], $value ['apellido'],$value ['DNI'],
                    $value ['telefono']);

                    $queryDates = "SELECT * FROM ". $this->tablename . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper"
                    . "WHERE d.idKeeper= (SELECT k.idKeeper FROM keeper k JOIN users u ON k.idUserr = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser() . "\")";
                    
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

            foreach ($this->keeperList as $keeper){
                if ($keeper->getNombreUser () == $userName){
                    foreach ($keeper->getFechas () as $estadias){
                        if (($desde >= $estadias->getDesde() && $hasta <= $estadias->getHasta()) 
                        || ($desde < $estadias->getDesde () &&  $hasta > $estadias->getHasta()) 
                        || ($desde>=$estadias->getDesde() && $desde<=$estadias->getHasta() && $hasta> $estadias->getHasta() )){
                            
                            $verificar=$estadias ;
                            return $verificar;
                        }
                        else {
                            $verificar = null ;
                            return $verificar ;
                        } 
                    }
                }
            }

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
        
       
    }
?>