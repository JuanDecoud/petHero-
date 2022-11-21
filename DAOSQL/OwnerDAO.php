<?php
    namespace DAOSQL;
    
    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Tarjeta as Tarjeta;
    use Models\Pet as Pet ;
    use \Exception as Exception;
    use LDAP\Result;
    use Models\FechasEstadias;

    class OwnerDAO implements IOwnerDAO
    {
        private $connection;
        private $tablename = "owner";
        private $tablePet = "pet";
        private $tableUser = "user";
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
            $this->connection->ExecuteNonQuery($queryUser, $parametersUser );
    
          
            
           ///Subimos sus TARJETAS a la DB
            $result = $this->connection->Execute($thirdQuery);


            ///Subimos el OWNER como tal a la DB
            $parametersOwner["idUser"] = $result[0]["idUser"];
            $this->connection->ExecuteNonQuery($queryOwner, $parametersOwner );



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
                $queryTarjeta = "INSERT INTO " . $this-> tableCard. " (numero,nombre,apellido,fechaVenc,codigo,idOwner)
                VALUES (:numero,:nombre,:apellido,:fechaVenc,:codigo,:idOwner)";
                $query ="SELECT idOwner FROM ". $this->tablename . 
                " o JOIN user u ON u.idUser = o.idUser".
                " WHERE "." nombreUser = \"". $username."\"";

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
                
                $parametersTarjeta["numero"] = $tarjeta->getNumero();
                $parametersTarjeta["nombre"] = $tarjeta ->getNombre();
                $parametersTarjeta["apellido"] = $tarjeta->getApellido();
                $parametersTarjeta["fechaVenc"] = $tarjeta -> getFechaVenc();
                $parametersTarjeta["codigo"]  = $tarjeta -> getCodigo();
                $parametersTarjeta["idOwner"] = $resultSet[0]["idOwner"];
                $this->connection->ExecuteNonQuery($queryTarjeta, $parametersTarjeta);
                
            
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
            

        }


    

        public function GetAll()
        {
            $ownerList = array();
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
                    array_push($ownerList,$owner);
                }


            }
            catch(Exception $ex)
            {
                throw $ex;
            }
            
        }

        public function comprobarLogin($username , $contrasena){
            $theOwner = null;

            try{
  
                $query = "SELECT * FROM ". $this->tablename. " o JOIN ". $this->tableUser. 
                " u ON o.idUser = u.idUser ". "WHERE u.nombreUser = \"". $username ."\"".
                " AND u.contrasena = \"" .$contrasena."\"";
            
                
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query );
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

        public function buscarId ($nombreOwner){
            $idOwner = null ;
            try {

                $query = "Call buscar_owner(?)";
                $parametro ['nombreUser'] = $nombreOwner ;
                
                $this->connection = Connection::GetInstance();
                $result=$this->connection->Execute ($query , $parametro , QueryType::StoredProcedure);
                foreach ($result as $row){
                    $idOwner= $row[0];
                }
                return $idOwner;
                
            } catch (Exception $ex) {
                throw $ex;
            }

        }

        public function buscarTarjeta($nombreOwner){
            $tarjeta = null ;
            try {

                $query = "Call buscar_tarjetaOwner(?)";
                $parametro ['nombreUser'] = $nombreOwner ;
                
                $this->connection = Connection::GetInstance();
                $result=$this->connection->Execute ($query , $parametro , QueryType::StoredProcedure);
                foreach ($result as $row){
                    
                    $tarjeta = new Tarjeta();
                    $tarjeta->setNumero($row[0]);
                    
                }
                return $tarjeta;
                
            } catch (Exception $ex) {
                throw $ex;
            }

            
        }

       
    }
?>