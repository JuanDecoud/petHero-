<?php
    namespace DAOSQL;

    use DAO\IPetDAO as IPetDAO;
    use Exception;
    use Models\Owner as Owner;
    use Models\Pet as Pet;

    class PetDAO implements IPetDAO
    {
        private $connection ;
        private $tableName = "pet";

        public function getAll (){}


        public function Add(Pet $pet)
        {

            $query = "CALL add_pet (?,?,?,?,?,?,?,?)";


            $parametros ['nombre'] = $pet->getNombre();
            $parametros ['raza'] = $pet->getRaza();
            $parametros ['tamaño'] = $pet->getTamano();
            $parametros ['imagen'] = $pet->getImg ();
            $parametros ['planVacunacion'] = $pet->getPlanVacunacion();
            $parametros['observacionesGrals'] = $pet->getObservacionesGrals();
            $parametros ['video'] = $pet->getVideo();

           // busco el id del owner  y lo agrego a los parametros
           $this->connection = Connection::GetInstance();
           
            $queryIDowner = "CALL buscar_owner (?)";
            $petOwner = $pet->getOwner();
            $ownerid['nombreUser'] = $petOwner->getNombreUser();

            $result  = $this->connection->Execute($queryIDowner ,$ownerid , QueryType::StoredProcedure);
            foreach ($result as $row){
                $parametros['idOwner'] = $row['idOwner'];
            }

            $this->connection->ExecuteNonQuery($query, $parametros, QueryType::StoredProcedure);

        }


        public function buscarPets ($nombreOwner){
            

            try
            {
                $query = "CALL buscar_pet (?)";
                $owner['nombreUser'] = $nombreOwner ;
                
                $this->connection = Connection::GetInstance();
                $resultado = $this->connection->Execute($query , $owner,QueryType::StoredProcedure);
                $listaMascota = array ();
                foreach ($resultado as $fila){
                    
                    $pet = new Pet ();
                    $pet->setNombre($fila[1]);
                    $pet->setRaza($fila[2]);
                    $pet->setTamano($fila[3]);
                    $pet->setImg($fila[4]);
                    $pet->setPlanVacunacion($fila[5]);
                    $pet->setObservacionesGrals($fila[6]);
                    $pet->setVideo($fila[7]);
                    array_push ($listaMascota , $pet);
                }
            }

            catch (Exception $ex)
            {
              
              echo "ocurrio un error";

            }
           
            return $listaMascota ;
        }

        public function buscarPet ($nombrePet , Owner $owner){
            $pet = null ;
            
            try
            {   
                $query = "CALL buscar_reservaPet (?,?)";
                $parametros['nombrePet'] = $nombrePet ;
                $parametros ['nombreUser'] = $owner->getNombreUser();
               
                
                $this->connection = Connection::GetInstance();
                $resultado = $this->connection->Execute($query , $parametros,QueryType::StoredProcedure);
                
                foreach ($resultado as $fila){
                 
                    $pet = new Pet ();
                    $pet->setNombre($fila[0]);
                    $pet->setRaza($fila[1]);
                    $pet->setTamano($fila[2]);
                    $pet->setImg($fila[3]);
                    $pet->setPlanVacunacion($fila[4]);
                    $pet->setObservacionesGrals($fila[5]);
                    $pet->setVideo($fila[6]);

                }
                
                $pet->setOwner($owner);
                return $pet ;

            } catch (Exception $th) {

                throw $th;
            }
        }

        public function comprobarPet ($nombrePet , $idOwner){
                $pet = null ;
            try
            {
                $query = "CALL buscarPetId(?,?)";

                $parametro['nombrePet'] = $nombrePet ;
                $parametro['idOwner'] = $idOwner ;

                $this->connection = Connection::GetInstance();
                $resultado = $this->connection->Execute($query ,$parametro ,QueryType::StoredProcedure);
                
                foreach ($resultado as $fila){
                    $pet = $fila[0];
                }
                return $pet ;
            }
            catch (Exception $Ex)
            {
                throw $Ex ;

            }
        }

    }


    






?>