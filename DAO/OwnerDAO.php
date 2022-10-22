<?php
    namespace DAO;
    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Tarjeta as Tarjeta;
    use Models\Pet as Pet ;

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

        public function obtenerUser ($username , $contrasena){
            $this->RetrieveData();
            $user = null ;
            foreach ($this->ownerList as $owner){
                if ($owner->getNombreUser() == $username && $owner->getContrasena() == $contrasena ){
                    $user = $owner ;
                }
            }

            return $user ;
        }
        private function SaveData()
        {
            $tarjeta = array() ;
            $pet = array() ;
        
            $arrayToEncode=array();
            foreach($this->ownerList as $owner)
            {

                $valuesArray["nombreUser"]=$owner->getNombreUser();
                $valuesArray["contrasena"]=$owner->getContrasena();
                $valuesArray["tipodeCuenta"]=$owner->getTipocuenta();
                
                // agrego la tarjeta 
                
                $tarjetaOwner = $owner->getTarjeta ();
                if ($tarjetaOwner != null){
                    $tarjeta['numero'] = $tarjetaOwner->getNumero ();
                    $tarjeta['nombre'] = $tarjetaOwner->getNombre ();
                    $tarjeta['fechaVenc'] = $tarjetaOwner->getFechaVenc ();
                    $tarjeta['codigo'] = $tarjetaOwner->getCodigo ();
                    
                }
                $valuesArray["tarjeta"] = $tarjeta;
               
 

                $petOwner = $owner->getPet ();
                if ($petOwner !=null){
                    $pet['nombre'] = $petOwner->getNombre();
                    $pet['raza'] = $petOwner->getRaza();
                    $pet ['tamano'] = $petOwner->getTamano();
                    $pet['planVacunacion'] = $petOwner ->GetPlanVacunacion();
                    $pet ['observacionesGrals'] = $petOwner->getObservacionesGrals();
                    $pet ['video'] = $petOwner->getVideo(); 
                    
                }
                $valuesArray['pet'] = $pet ;
   


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
                    $owner=new owner ();
                    /*$owner=new Owner( $valuesArray["nombreUser"],$valuesArray["contrasena"], 
                    $valuesArray["tipodeCuenta"]);
                        */
                   $owner->setNombreUser( $valuesArray["nombreUser"]);
                   $owner->setContrasena($valuesArray["contrasena"]);
                   $owner->setTipodecuenta ($valuesArray["tipodeCuenta"]);

                    $tarjeta = new Tarjeta ();
                    foreach ($valuesArray['tarjeta'] as $value){
                        $tarjeta->setNumero($value['numero'] );
                        $tarjeta->setNombre($value['nombre']);
                        $tarjeta->setFechaVenc($value['fechaVenc']);
                        $tarjeta->setCodigo($value['codigo'] );
                    }
                    $owner->setTarjeta($tarjeta);


                    $pet  = new Pet ();
                    foreach ($valuesArray['pet'] as $value){
                        $pet->setNombre($value['nombre']);
                        $pet->setRaza($value['raza']);
                        $pet->setTamano($value ['tamano']);
                        $pet ->setPlanVacunacion($value['planVacunacion'] );
                        $pet->setObservacionesGrals($value ['observacionesGrals']);
                        $pet->setVideo($value ['video']);
                    }

                    $owner->setPet($pet);


                    array_push($this->ownerList, $owner);
                    
                }
            }
        }
    }

?>