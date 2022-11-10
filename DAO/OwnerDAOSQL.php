<?php
    namespace DAO;
    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Tarjeta as Tarjeta;
    use Models\Pet as Pet ;
    use \Exception as Exception;
use LDAP\Result;

    class OwnerDaoSQL implements IOwnerDAO
    {
        private $connection;
        private $tablename = "owner";
        private $tablePet = "pet";
        private $tableUser = "users";
        private $tableCard= "tarjeta";

        public function Add(Owner $owner)
        {
            $queryUser =  "INSERT INTO " . $this-> tableUser. " (nombreUser, contrasena,tipoDeCuenta,nombre,apellido,dni,telefono)
            VALUES (:nombreUser, :contrasena,:tipoDeCuenta,:nombre,:apellido,:dni,:telefono)";

            $queryOwner= "INSERT INTO ".$this->tablename." (idUser) VALUES (:idUser);";
            
            $queryTarjeta = "INSERT INTO ".$this->tableCard." (numero,nombre,apellido,fechaVenc,codigo,idOwner) VALUES (:numero,:nombre,:apellido,:fechaVenc,:codigo,:idOwner);";

            $queryPet= "INSERT INTO ".$this->tablePet." (nombre,raza,tamaño,imagen,planVacunacion,observacionesGrals,video,idDueño) VALUES (:nombre,:raza,:tamaño,:imagen,:planVacunacion,:observacionesGrals,:video,:idDueño)";

            $thirdQuery = "SELECT idUser FROM ". $this->tableUser . " WHERE "." nombreUser = \"". $owner->getNombreUser()."\"";

            ///$fourthQuery = ;
            ///Creamos el USER en DB
            $parametersUser["nombreUser"] = $owner->getNombreUser();
            $parametersUser["contrasena"] = $owner->getContrasena();
            $parametersUser["tipoDeCuenta"] = $owner->getTipodecuenta();
            $parametersUser["nombre"] = $owner->getNombre();
            $parametersUser["apellido"] = $owner->getApellido();
            $parametersUser["dni"] = $owner->getDni();
            $parametersUser["telefono"] = $owner->getTelefono();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($queryUser, $parametersUser);
            
            $tarjeta = $owner ->getTarjeta();
            
            ///Subimos sus TARJETAS a la DB
            $result = $this->connection->Execute($thirdQuery);
            foreach($tarjeta as $ts){
                $parametersTarjeta["numero"] = $ts->getNumero();
                $parametersTarjeta["nombre"] = $ts ->getNombre();
                $parametersTarjeta["apellido"] = $ts->getApellido();
                $parametersTarjeta["fechaVenc"] = $ts -> getFechaVenc();
                $parametersTarjeta["codigo"]  = $ts -> getCodigo();
                $parametersTarjeta["idOwner"] = $result[0]["idUser"];
                $this->connection->ExecuteNonQuery($queryTarjeta, $parametersUser);
            }
            

            ///Subimos el OWNER como tal a la DB
            $parametersOwner["idUser"] = $result[0]["idUser"];
            $this->connection->ExecuteNonQuery($queryOwner, $parametersOwner);

            ///Subimos el PET a la DB
            $pets = $owner->getPet();

            foreach($pets as $pet){
                $parametersPet["nombre"] = $pet->getNombre();
                $parametersPet["raza"] = $pet ->getRaza();
                $parametersPet["tamaño"] = $pet->getTamano();
                $parametersPet["imagen"] = $pet -> getImg();
                $parametersPet["planVacunacion"]  = $pet -> getPlanVacunacion();
                $parametersPet["observacionesGrals"] = $pet -> getObservacionesGrals();
                $parametersPet["video"] = $pet -> getVideo();
                $parametersPet["idDueño"] = $result[0]["idUser"];
                $this->connection->ExecuteNonQuery($queryPet, $parametersPet);
            }

        }

        public function obtenerUser($username){
            $theOwner = null;

            try{
                $query = "SELECT * FROM ". $this->tablename. " o JOIN ". $this->tableUser. 
                " u ON o.idUser = u.idUser ". "WHERE u.nombreUser = \"". $username ."\"";
            
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);

                

                foreach ($resultSet as $row)
                {            
                    $theOwner = new Owner();
                    $theOwner -> setNombre($row["nombre"]);
                    $theOwner -> setApellido($row["apellido"]);
                    $theOwner -> setContrasena($row["contrasena"]);
                    $theOwner -> setDni($row["dni"]);
                    $theOwner -> setNombreUser($row["nombreUser"]);
                    $theOwner -> setTelefono($row["telefono"]);
                    $theOwner -> setTipodecuenta($row["tipoDeCuenta"]);
                    
                }
            }
            catch (Exception $ex)
            {
                throw $ex;
            }

            return $theOwner;
        } 

        public function agregarTarjeta ($username , Tarjeta $tarjeta){
           
            try
            {
                $queryTarjeta = "INSERT INTO " . $this-> tableUser. " (numero,nombre,apellido,fechaVenc,codigo,idOwner)
                VALUES (:numero,:nombre,:apellido,:fechaVenc,:codigo,:idOwner)";
                $query ="SELECT idOwner FROM ". $this->tablename . 
                " o JOIN users u ON u.idUser = o.idUser".
                " WHERE "." nombreUser = \"". $username."\"";

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);

                foreach($tarjeta as $ts){
                    $parametersTarjeta["numero"] = $ts->getNumero();
                    $parametersTarjeta["nombre"] = $ts ->getNombre();
                    $parametersTarjeta["apellido"] = $ts->getApellido();
                    $parametersTarjeta["fechaVenc"] = $ts -> getFechaVenc();
                    $parametersTarjeta["codigo"]  = $ts -> getCodigo();
                    $parametersTarjeta["idOwner"] = $resultSet[0]["idOwner"];
                    $this->connection->ExecuteNonQuery($queryTarjeta, $parametersTarjeta);
                }
            
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
            

        }


        public function agregarPets($username ,Pet $pet ){
            try
            {
                $queryPet = "INSERT INTO ".$this->tablePet." (nombre,raza,tamano,imagen,planVacunacion,observacionesGrals,video,idDueno) 
                VALUES (:nombre,:raza,:tamano,:imagen,:planVacunacion,:observacionesGrals,:video,:idDueno)";
                
                $query ="SELECT idOwner FROM ". $this->tablename . 
                " o JOIN users u ON u.idUser = o.idUser".
                " WHERE "." nombreUser = \"". $username."\"";
                
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query);

                
                $pP["nombre"] = $pet->getNombre();
                $pP["raza"] = $pet ->getRaza();
                $pP["tamano"] = $pet->getTamano();
                $pP["imagen"] = $pet -> getImg();
                $pP["planVacunacion"]  = $pet -> getPlanVacunacion();
                $pP["observacionesGrals"] = $pet -> getObservacionesGrals();
                $pP["video"] = $pet -> getVideo();
                $pP["idDueno"] = $result[0]["idOwner"];
                

                var_dump($pP);

                $this->connection->ExecuteNonQuery($queryPet, $pP);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }

        }

        public function GetAll()
        {
            $ownerList = array();
            /*
            try
            {
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUser = u.idUser ";
                
                $queryTarjeta = "SELECT * FROM ".$this->tableCard." (numero,nombre,apellido,fechaVenc,codigo,idOwner) VALUES (:numero,:nombre,:apellido,:fechaVenc,:codigo,:idOwner);";

                $queryPet = "SELECT * FROM ". $this->tablePet;


                $this->connection = Connection::GetInstance();

                $resultUser = $this->connection->Execute($query);

                foreach($resultUser as $value){
                    $owner = new Owner($value['nombreUser'],$value ['contrasena'],$value ['tipodeCuenta'],
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
            catch(Exception $ex)
            {
                throw $ex;
            }
            */
        }

        public function comprobarLogin($username , $contrasena){
            $theOwner = null;

            try{
                $query = "SELECT * FROM ". $this->tablename. " o JOIN ". $this->tableUser. 
                " u ON o.idUser = u.idUser ". "WHERE u.nombreUser = \"". $username ."\""." AND u.contrasena = \"" .$contrasena."\"";
            
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);

                

                foreach ($resultSet as $row)
                {            
                    $theOwner = new Owner();
                    $theOwner -> setNombre($row["nombre"]);
                    $theOwner -> setApellido($row["apellido"]);
                    $theOwner -> setContrasena($row["contrasena"]);
                    $theOwner -> setDni($row["dni"]);
                    $theOwner -> setNombreUser($row["nombreUser"]);
                    $theOwner -> setTelefono($row["telefono"]);
                    $theOwner -> setTipodecuenta($row["tipoDeCuenta"]);
                    
                }
            }
            catch (Exception $ex)
            {
                throw $ex;
            }

            return $theOwner;


        }


       
    }
?>