<?php
    namespace DAO;
    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Tarjeta as Tarjeta;
    use Models\Pet as Pet ;

    class OwnerDao implements IOwnerDAO
    {
       
       
        private $ownerList = array();

        public function Add(Owner $owner)
        {
            
            array_push($this->ownerList, $owner);
            $this->SaveData();
        }

        public function agregarTarjeta ($username , Tarjeta $tarjeta){
            $this->RetrieveData();
            foreach ($this->ownerList as $owner){
                if ($owner -> getNombreUser() ==  $username){
                    $owner->agregarTarjeta($tarjeta);
                }
            }
            $this->SaveData();
        }
        public function GetAll()
        {
            $this->RetrieveData();
            return $this->ownerList;
        }

        public function agregarPets ($username ,Pet $pet ){

            $this->RetrieveData();
            foreach($this->ownerList  as $owner){
                if ($owner->getNombreUser()==$username)
                    $owner->agregarPet ($pet);
                  
            }
            $this->SaveData();
        }


        public function comprobarLogin($username , $contrasena){
            $this->RetrieveData();
            $user = null ;
            foreach ($this->ownerList as $owner){
                if ($owner->getNombreUser() == $username && $owner->getContrasena() == $contrasena ){
                    $user = $owner ;
                }
            }
            return $user ;
        }
        public function obtenerUser ($username){
            $this->RetrieveData();
            $user = null ;
            foreach ($this->ownerList as $owner){
                if ($owner->getNombreUser() == $username  ){
                    $user = $owner ;
                }
            }
            return $user ;
        }

        public function buscarTarjeta ($nombreUsuario){
            $this->RetrieveData();
            $nuevaTarjeta = null ;
            foreach ($this->ownerList as $owner){
                if ($owner->getNombreUser()== $nombreUsuario){
                    $listaTarjet = $owner->getTarjeta();
                    foreach ($listaTarjet as $tarjeta){
                        $nuevaTarjeta = new Tarjeta ();
                        $nuevaTarjeta->setNombre($tarjeta->getNombre());
                        $nuevaTarjeta ->setNumero($tarjeta->getNumero());
                        $nuevaTarjeta ->setCodigo($tarjeta->getCodigo());
                        $nuevaTarjeta->setFechaVenc($tarjeta->getFechaVenc());
                        $nuevaTarjeta->setApellido($tarjeta->getApellido());
                    }
                }
                
            }
            return $nuevaTarjeta ;
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
                $valuesArray ['nombre'] = $owner->getNombre();
                $valuesArray ['apellido'] = $owner->getApellido();
                $valuesArray ['DNI'] = $owner->getDni();
                $valuesArray ['telefono'] = $owner->getTelefono();
                // agrego la tarjeta 
                
                $tarjetaOwner = $owner->getTarjeta ();
                $valuesArray['tarjeta'] = array ();
                if ($tarjetaOwner != null){
                    foreach ($tarjetaOwner as $tarjeta){
                        $arrayTarjeta['numero'] = $tarjeta->getNumero ();
                        $arrayTarjeta['nombre'] = $tarjeta->getNombre ();
                        $arrayTarjeta ['apellido'] = $tarjeta->getApellido ();
                        $arrayTarjeta['fechaVenc'] = $tarjeta->getFechaVenc ();
                        $arrayTarjeta['codigo'] = $tarjeta->getCodigo ();
                        array_push($valuesArray['tarjeta'] , $arrayTarjeta);
                    }
                    
                }
                
    
                
              /* $valuesArray['pets']=array ();
                foreach($owner->getPetList() as $pet){
                    $valuesArray["pets"][] = array(
                        'nombre' => $pet->getNombre(),
                        'raza' => $pet->getRaza(),
                        'tamano' => $pet->getTamano(),
                        'planVacunacion' => $pet->GetPlanVacunacion(),
                        'observacionesGrals' => $pet->getObservacionesGrals(),
                        'video' => $pet->getVideo(),
                        'imagen' => $pet->getImg()
                    );
                }*/

                $petarray = $owner->getPet();
                $valuesArray['pets']=array ();
                
                    foreach ($petarray as $mascota){
                        $value['nombre']=$mascota->getNombre ();
                        $value['raza']=$mascota->getRaza ();
                        $value['tamano']=$mascota->getTamano ();
                        $value['planVacunacion']=$mascota->GetPlanVacunacion ();
                        $value['observacionesGrals']=$mascota->getObservacionesGrals ();
                        $value['video']=$mascota->getVideo ();
                        $value['imagen']=$mascota->getImg ();
                        array_push($valuesArray['pets'] ,$value);
                    }
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent= json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents(ROOT."Data/owner.json" , $jsonContent);
        }

        private function RetrieveData()
        {
            
            $tarjeta = null;
            $owner = null ;
            $pet = null ;
            if(file_exists(ROOT."Data/owner.json" ))
            {
                $jsonContent=file_get_contents(ROOT."Data/owner.json" );
                $arrayToDecode=($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {   
                    $owner=new Owner ();
          
                   $owner->setNombreUser( $valuesArray["nombreUser"]);
                   $owner->setContrasena($valuesArray["contrasena"]);
                   $owner->setTipodecuenta ($valuesArray["tipodeCuenta"]);
                   $owner->setNombre($valuesArray["nombre"]);
                   $owner->setApellido($valuesArray["apellido"]);
                   $owner->setDni($valuesArray["DNI"]);
                   $owner->setTelefono($valuesArray["telefono"]);

                  if ($valuesArray['tarjeta'] != null){
                    foreach ($valuesArray['tarjeta'] as $value){
                        
                        $tarjeta = new Tarjeta ();
                        $tarjeta->setNombre($value['nombre']);
                        $tarjeta ->setNumero($value['numero']);
                        $tarjeta ->setCodigo($value['codigo']);
                        $tarjeta->setFechaVenc($value['fechaVenc']);
                        $tarjeta->setApellido($value['apellido']);
                        $owner->agregarTarjeta($tarjeta);
                    
                    }                   
                  }
                     
                    if ($valuesArray['pets']!=null){

                        foreach ($valuesArray['pets'] as $value){
                            $pet  = new Pet ();
                            $pet->setNombre($value['nombre']);
                            $pet->setRaza($value['raza']);
                            $pet->setTamano($value ['tamano']);
                            $pet ->setPlanVacunacion($value['planVacunacion'] );
                            $pet->setObservacionesGrals($value ['observacionesGrals']);
                            $pet->setVideo($value ['video']);
                            $pet->setImg($value ['imagen']);
                            $owner->agregarPet($pet);
                        }
    
                    }
    
                    array_push($this->ownerList, $owner);

                    
                }
            }
        }
       
    }
?>