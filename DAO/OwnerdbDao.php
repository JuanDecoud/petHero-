<?php 
    namespace DAO ;
    use Models\Owner as Owner;
    use DAO\QueryType as QueryType;
    use DAO\Connection as Connection;

    class OwnerdbDAO {
        private $connection ;
        private $table = "owner";



        public function add (Owner $owner ){

            $query = " CALL owners_add(?,?,?,?,?,?,?)";
           
            $parametros ['nombreUser'] = $owner->getNombreUser();
            $parametros ['contrasena']= $owner->getNombreUser();
            $parametros ['tipoCuenta']= $owner->getTipocuenta();
            $parametros ['nombre']= $owner->getNombre();
            $parametros ['apellido']= $owner->getApellido();
            $parametros ['dni']= $owner->getDni();
            $parametros ['telefono']= $owner->getTelefono();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parametros, QueryType::StoredProcedure);
        }

        public function obtenerUser($usuario , $contraseña)
        {
            $ownerList = array();
            $query = "CALL comprobarUser_owner(?,?)";
            $this->connection = Connection::GetInstance();
            $ownerList ['nombreUser'] = $usuario ;
            $ownerList['contrasena'] = $contraseña ;
            $result = $this->connection->Execute($query, $ownerList, QueryType::StoredProcedure);
            $owner = null ;

            foreach($result as $row)
            {
                $owner = new Owner();
                $owner->setNombreUser($row["nombreUser"]);
                $owner->setContrasena($row["contrasena"]);
                $owner->setNombre($row["nombre"]);
                $owner->setApellido($row["apellido"]);
                $owner->setDni($row["dni"]);
                $owner->setTelefono($row["telefono"]);

                
            }

            return $owner;
        }


    }


?>