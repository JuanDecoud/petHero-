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
                $parametersKeeper["tipoMascota"] = $keeper->getTipo();
                $parametersKeeper["remuneracion"] = $keeper->getRemuneracion();
                $result = $this->connection->Execute($thirdQuery);
                $parametersKeeper["idUserr"] = $result[0]["idUser"];
                var_dump($result);

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
            
        }

        public function obtenerUser($username){
            $theKeeper = null;

            try{
                
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUserr = u.idUser ";

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

        
       
    }
?>