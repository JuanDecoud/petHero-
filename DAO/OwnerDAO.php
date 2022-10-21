<?php
    namespace DAO;
    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Tarjeta as Tarjeta;

    class OwnerDao implements IOwnerDAO
    {
        private $ownerList ;

        public function Add(Owner $owner)
        {
            $this->RetrieveData();
            array_push($this->ownerList, $owner);
            $this->SaveData();
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

                $valuesArray["nombreUser"]=$owner->getNombreUser();
                $valuesArray["contrasena"]=$owner->getContrasena();
                $valuesArray["tipodeCuenta"]=$owner->getTipocuenta();
                
                    /*$tarjeta = $owner->getTarjeta ();
             
                    $valuesArray["tarjeta"][] = array(
                        'numero' => $tarjeta->getNumero(),
                        'nombre' => $tarjeta->getFechaVenc(),
                        'fechaVenc' => $tarjeta->getDescription(),
                        'codigo' => $tarjeta->getCodigo()
                        
                    );
            
*/
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent= json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents(ROOT."Data/owner.json" , $jsonContent);
        }

        private function RetrieveData()
        {
            $this->ownerList=array();
            $tarjeta = null ;
            $owner = null ;
            if(file_exists(ROOT."Data/owner.json" ))
            {
                $jsonContent=file_get_contents(ROOT."Data/owner.json" );
                $arrayToDecode=($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $owner=new Owner( $valuesArray["nombreUser"],$valuesArray["contrasena"], 
                    $valuesArray["tipodeCuenta"]);
                    /*$owner->setId($valuesArray["id"]);
                    $owner->setNombreUser($valuesArray["nombreUser"]);
                    $owner->setContrasena($valuesArray["contrasena"]);
                    $owner->setDni($valuesArray["dni"]);
                    $owner->setEmail($valuesArray["email"]);*/
                   // $owner->setTarjeta($valuesArray["tarjeta"]);
                  /* foreach ($valuesArray['tarjeta'] as $value){
                    $tarjeta = new Tarjeta ($value['numero'] ,$value['nombre'] ,$value['fechaVenc'] ,$value['codigo']  );

                   }
                   $owner->setTarjeta($tarjeta);*/
                    array_push($this->ownerList, $owner);
                    
                }
            }
        }
    }

?>