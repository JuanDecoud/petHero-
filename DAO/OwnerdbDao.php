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

        public function owner_getAll()
        {
            $ownerList = array();
            $query = "CALL owner_getAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $ownerList, QueryType::StoredProcedure);

            foreach($result as $row)
            {
                $owner = new Owner();
                $owner->setNombreUser($row["nombreUser"]);
                array_push($ownerList, $owner);
            }

            return $ownerList;
        }


    }


?>