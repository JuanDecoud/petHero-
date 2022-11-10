<?php
    namespace DAO;

    use DAO\IPetDAO as IPetDAO;
    use Models\Owner as Owner;
    use Models\Pet as Pet;

    class PetDAOSQL implements IPetDAO
    {
        private $connection ;
        private $tableName = "pet";

  


        public function Add(Pet $pet)
        {

            $query = "CALL add_pet (?,?,?,?,?,?,?,?)";


            $parametros ['nombre'] = $pet->getNombre();
            $parametros ['raza'] = $pet->getRaza();
            $parametros ['tanio'] = $pet->getTamano();
            $parametros ['imagen'] = $pet->getImg ();
            $parametros ['planVacunacion'] = $pet->getPlanVacunacion();
            $parametros['observacionesGrals'] = $pet->getObservacionesGrals();
            $parametros ['video'] = $pet->getVideo();

           // busco el id del owner  y lo agrego a los parametros
           $this->connection = Connection::GetInstance();
           
            $queryIDowner = "CALL buscar_owner (?)";
            $petOwner = $pet->getOwner();
            $ownerid['id'] = $petOwner->getNombreUser();

            $result  = $this->connection->Execute($queryIDowner ,$ownerid , QueryType::StoredProcedure);
            foreach ($result as $row){
                $parametros['idOwner'] = $row['idOwner'];
            }

            $this->connection->ExecuteNonQuery($query, $parametros, QueryType::StoredProcedure);

        }

        public function GetAll()
        {
            $this->RetrieveData();

            return $this->petList;
        }

        public function retrievePet ($petName){
            $this->RetrieveData();
            $petFound = null ;
            foreach ($this->petList as $pet){
                if ($petName == $pet->getNombre()){
                    $petFound = $pet ;
                }
            }
            return $petFound ;

        }

        private function Save()
        {
            $arrayToEncode = array();
            $petowner = array ();
            $valuesOwner = array();

            foreach($this->petList as $pet)
            {              
                //$valuesArray["petId"] = $pet->getId();

                $valuesArray["petName"] = $pet->getNombre();
                $valuesArray["petBreed"] = $pet->getRaza();
                $valuesArray["petSize"] = $pet->getTamano();
                $valuesArray["petObserv"] = $pet->getObservacionesGrals();
                $valuesArray["petVideo"] = $pet->getVideo();
                $valuesArray['petImg'] = $pet->getImg();
                $valuesArray["petVacc"] = $pet->getPlanVacunacion();


                
                $petowner = $pet->getOwner ();
                if ($petowner !=null){
                $valuesOwner["nombreUser"]=$petowner->getNombreUser();     
          
                }
                
                $valuesArray['owner'] = $valuesOwner ;

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            
            file_put_contents('Data/pets.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->petList = array();

            if(file_exists('Data/pets.json'))
            {
                $jsonContent = file_get_contents('Data/pets.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
                $owner = new Owner ();

                foreach($arrayToDecode as $valuesArray)
                {
                    $pet = new Pet();
                   // $pet->setId($valuesArray["petId"]);
                    $pet->setNombre($valuesArray["petName"]);
                    $pet->setRaza($valuesArray["petBreed"]);
                    $pet->setTamano($valuesArray["petSize"]);
                    $pet->setPlanVacunacion($valuesArray["petVacc"]);
                    $pet->setObservacionesGrals($valuesArray["petObserv"]);
                    $pet->setVideo($valuesArray["petVideo"]);
                    $pet->setImg($valuesArray["petImg"]);

                    $array = $valuesArray['owner'];
                    $owner->setNombreUser($array['nombreUser']);
                    $pet->setOwner($owner);

                    array_push($this->petList, $pet);
                    
                }
            }
        }


        public function buscarPets ($userName){
            $this->RetrieveData();
            $petList = array ();
            foreach($this->petList as $pet){
                $owner = $pet->getOwner ();
                if ($owner->getNombreUser()==$userName){
                    array_push($petList , $pet);
                }
            }
            return $petList;
        }
    }
?>