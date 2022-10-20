<?php
    namespace DAO;

    use DAO\IPetDAO as IPetDAO;
    use Models\Pet as Pet;

    class PetDAO implements IPetDAO
    {
        private $petList = array();

        public function Add(Pet $pet)
        {
            $this->RetrieveData();
            
            array_push($this->petList, $pet);

            $this->Save();
        }

        public function GetAll()
        {
            $this->RetrieveData();

            return $this->petList;
        }

        private function Save()
        {
            $arrayToEncode = array();

            foreach($this->petLIst as $pet)
            {
                $valuesArray["petId"] = $pet->getId();
                $valuesArray["petName"] = $pet->getNombre();
                $valuesArray["petOwner"] = $pet ->getOwner();
                //$valuesArray["petOwner"] = json_decode($_SESSION["Owner"],true); Posible solución al conseguir las mascotas de la persona.
                $valuesArray["petBreed"] = $pet->getRaza();
                $valuesArray["petSize"] = $pet->getTamano();
                $valuesArray["petVacc"] = $pet->getPlanVacunacion();
                $valuesArray["petObserv"] = $pet->getObservacionesGrals();
                $valuesArray["petVideo"] = $pet->getVideo();


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

                foreach($arrayToDecode as $valuesArray)
                {
                    $pet = new Pet();
                    $pet->setId($valuesArray["petId"]);
                    $pet->setNombre($valuesArray["petName"]);
                    $pet->setOwner($valuesArray["petOwner"]);
                    $pet->setRaza($valuesArray["petBreed"]);
                    $pet->setTamano($valuesArray["petSize"]);
                    $pet->setPlanVacunacion($valuesArray["petVacc"]);
                    $pet->setObservacionesGrals($valuesArray["petObserv"]);
                    $pet->setVideo($valuesArray["petVideo"]);
                    array_push($this->petList, $pet);
                }
            }
        }
    }
?>