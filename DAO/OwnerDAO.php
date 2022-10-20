<?php
    namespace DAO;
    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    

    class OwnerDao implements IOwnerDAO
    {
        private $ownerList;

        public function Add(Owner $owner)
        {
            $this->RetrieveData();
            array_push($this->ownerList, $owner);
        }
        public function GetAll()
        {
            $this->RetrieveData();
            return $this->ownerList;
        }
        private function SaveData()
        {
            $arrayToEncode=array();
            foreach($this->ownerList as $owner)
            {
                $valuesArray["id"]=$owner->getId();
                $valuesArray["nombreUser"]=$owner->getNombreUser();
                $valuesArray["contrasena"]=$owner->getContrasena();
                $valuesArray["dni"]=$owner->getDni();
                $valuesArray["email"]=$owner->getEmail();
                $valuesArray["tarjeta"]=$owner->getTarjeta();

                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent= json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents('Data\owner.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->ownerList=array();
            if(file_exists('Data/owner.json'))
            {
                $jsonContent=file_get_contents('Data/owner.json');
                $arrayToDecode=($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $owner=new Owner($valuesArray["id"], $valuesArray["nombreUser"],$valuesArray["contrasena"], 
                    $valuesArray["dni"], $valuesArray["email"]);
                    /*$owner->setId($valuesArray["id"]);
                    $owner->setNombreUser($valuesArray["nombreUser"]);
                    $owner->setContrasena($valuesArray["contrasena"]);
                    $owner->setDni($valuesArray["dni"]);
                    $owner->setEmail($valuesArray["email"]);*/
                    $owner->setTarjeta($valuesArray["tarjeta"]);

                    array_push($this->ownerList, $owner);
                    
                }
            }
        }
    }

?>