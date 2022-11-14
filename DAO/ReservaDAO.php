<?php
    namespace DAO;

    use DAO\IReservaDAO as IReservaDAO;
    use Models\Estadoreserva as Estadoreserva;
    use Models\Pet as Pet ;
    use Models\Keeper as Keeper ;
    use Models\Reserva ;
    use Models\Owner ;

    class ReservaDAO implements IReservaDAO
    {
        private $reservaList = array();

        public function Add(Reserva $reserva)
        {
            $this->RetrieveData();
            $reserva->setEstado(Estadoreserva::Pendiente);
            array_push($this->reservaList, $reserva);

            $this->SaveData();
        }

        public function GetAll()
        {
            $this->RetrieveData();

            return $this->reservaList;
        }

        public function getLista (){
            return $this->reservaList;
        }

        public function reservasAceptadas (){
            $reservasAceptadas = array ();
            foreach ($this->reservaList as $reserva){
                if ($reserva ->getEstado () == Estadoreserva::Aceptada){
                    array_push($reservasAceptadas , $reserva);
                }
            }
            return $reservasAceptadas ;
        }

        public function buscarReservas (Keeper $keeper){
            $this->RetrieveData();
            $listadeReservas = array();
            foreach ($this->reservaList as $reserva ){
                $keeperReserva = $reserva->getKeeper();
                if($keeperReserva->getNombreUser()==$keeper->getNombreUser() 
                && $reserva->getEstado()==Estadoreserva::Pendiente){
                    array_push($listadeReservas , $reserva);
                }
            }
            return $listadeReservas;      
        }

        private function SaveData()
        {
            $arrayToEncode = array();
            $pet = null;
            $keeper = null;

            foreach($this->reservaList as $reserva)
            {
                $valuesArray["fdesde"] = $reserva->getFechadesde();
                $valuesArray["fhasta"] = $reserva->getFechahasta();
                $valuesArray["importeReserva"] = $reserva->getImporteReserva();
                $valuesArray["importeTotal"] = $reserva->getImporteTotal();
                

                $pet = $reserva -> getPet();
                if($pet != null){
                    $valuepet['nombre']=$pet->getNombre ();
                    $valuepet['raza']=$pet->getRaza ();
                    $valuepet['tamano']=$pet->getTamano ();
                    $valuepet['planVacunacion']=$pet->GetPlanVacunacion ();
                    $valuepet['observacionesGrals']=$pet->getObservacionesGrals ();
                    $valuepet['video']=$pet->getVideo ();
                    $valuepet['imagen']=$pet->getImg ();
                    $owner = $pet->getOwner();
                    $valueOwner['nombreUser'] = $owner->getNombreUser();
                    $valuepet['owner'] = $valueOwner ;
                    $valuesArray["pet"] = $valuepet;
                  
                }
                

                $keeper = $reserva -> getKeeper();
                if ($keeper != null){
                    $value['nombreUser'] = $keeper->getNombreUser();
                    $value ['contrasena'] = $keeper->getContrasena();
                    $value ['tipodeCuenta'] = $keeper->getTipodecuenta ();
                    $value ['tipoMascota'] = $keeper->getTipo();
                    $value ['remuneracion'] = $keeper->getRemuneracion();
                    $value ['nombre'] = $keeper->getNombre();
                    $value ['apellido'] = $keeper->getApellido();
                    $value ['DNI'] = $keeper->getDni();
                    $value ['telefono'] = $keeper->getTelefono();
                    $valuesArray["keeper"] = $value;
                }

               $valuesArray['estado'] = $reserva ->getEstado ();
               

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            
            file_put_contents('Data/reserva.json', $jsonContent);
        }

        private function RetrieveData()
        {
           
            $pet = null;
            $keeper = null;


            if(file_exists('Data/reserva.json'))
            {
                $jsonContent = file_get_contents('Data/reserva.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $reserva = new Reserva();

                    $reserva->setImporteReserva($valuesArray["importeReserva"]);
                    $reserva->setImporteTotal($valuesArray["importeTotal"]);
                    
                                        
                    if($valuesArray["pet"] != null){
                        $pet = new Pet();
                        $pet->setNombre($valuesArray["pet"]['nombre']);
                        $pet->setRaza($valuesArray["pet"]['raza']);
                        $pet->setTamano($valuesArray["pet"] ['tamano']);
                        $pet ->setPlanVacunacion($valuesArray["pet"]['planVacunacion'] );
                        $pet->setObservacionesGrals($valuesArray["pet"] ['observacionesGrals']);
                        $pet->setVideo($valuesArray["pet"] ['video']);
                        $pet->setImg($valuesArray["pet"] ['imagen']);
                        $owner = new Owner ();
                        $owner->setNombreUser($valuesArray['pet']['owner']['nombreUser']);
                        $pet->setOwner($owner);
                        
                    }

       

                    $reserva-> setPet($pet);

                    if($valuesArray["keeper"] != null){
                        $keeper = new Keeper($valuesArray["keeper"]['nombreUser'],$valuesArray["keeper"]['contrasena'], $valuesArray["keeper"]['tipodeCuenta'],$valuesArray["keeper"]['tipoMascota'],$valuesArray["keeper"]['remuneracion'],$valuesArray["keeper"]['nombre'],$valuesArray["keeper"]['apellido'],$valuesArray["keeper"]['DNI'],$valuesArray["keeper"]['telefono']);

                    }
                        
                    $reserva->setKeeper($keeper); 
                    $reserva->setEstado($valuesArray['estado']);
                    array_push($this->reservaList, $reserva);
                }
            }
        }

 

        public function borrarReservaxNombre($nombrePet){
            $this -> RetrieveData();

            $pet = null;
            foreach($this-> reservaList as $reserva){
                
                $pet = $reserva -> getPet();
                echo($nombrePet . '+');
                echo($pet->getNombre() . '------------------------------');
                if($pet ->getNombre() == $nombrePet){
                    $this -> borrarReserva($reserva); /// NO LLEGA puede ser por el if de arriba
                }
            }
     
        }

        private function borrarReserva(Reserva $reserva){
            
            if(($clave = array_search($reserva, $this->reservaList) !== false)){
                unset($this -> reservaList[$clave]);
            }

            $this -> SaveData();
        }

        public function buscarReserva($nombreKeeper, $nombrePet){
            $this -> RetrieveData();

            $keeper = null;
            $pet = null;
            foreach($this-> reservaList as $reserva){
                $keeper = $reserva->getKeeper();
                $pet = $reserva -> getPet();
                if($keeper -> getNombreUser() == $nombreKeeper && $pet ->getNombre() == $nombrePet){
                    return $reserva;     /// NO LLEGA puede ser por el if de arriba
                }
            }
            return null;
        }

        public function buscarReservaxEstado ($lista,$nombreUser , $estado ){
           
            $listaReservas = array ();
            foreach($lista as $reserva){
                
                $pet = $reserva->getPet();
                $owner = $pet->getOwner();
                if ($owner->getNombreUser() == $nombreUser && $pet->getNombre() 
                && $reserva->getEstado () == $estado){
                    array_push($listaReservas , $reserva);
                }
            }
            return $listaReservas;
        }

        public function buscarReservaxEstadoKeeper ($lista,$nombreUser , $estado ){
     
           
            $listaReservas = array ();
         
            foreach($lista as $reserva){
                
                $pet =  $reserva->getPet();
                $keeper = $reserva->getKeeper();
                if ($keeper->getNombreUser() == $nombreUser && $pet->getNombre() 
                && $reserva->getEstado () == $estado){
                    array_push($listaReservas , $reserva);
                }
            }
            return $listaReservas;
        }

        public function buscarReservaEnCurso ($lista,$nombreUser , $estado , $desde , $hasta ){
           
            $listaReservas = array ();
            foreach($lista as $reserva){
                
                $pet = $reserva->getPet();
                $keeper = $reserva->getKeeper();
                if ($keeper->getNombreUser() == $nombreUser 
                && $reserva->getEstado () == $estado 
                && $reserva->getFechadesde()== $desde
                && $reserva->getFechahasta()== $hasta ){
                    array_push($listaReservas , $reserva);
                }
            }
            return $listaReservas;
        }

        public function cambiarEstado ( $desde , $hasta , $nombreUsuario ,$estado){
            $this->RetrieveData();
            foreach ($this->reservaList as $reserva){
                $keeper = $reserva->getKeeper ();
                if ($reserva->getFechadesde ()== $desde && $reserva->getFechahasta ()==$hasta 
                && $keeper->getNombreUser() ==$nombreUsuario ){
                    $reserva->setEstado ($estado);
                    
                }
            }
            
            $this->SaveData();
        }

        public function cambiarEstadoOwner ( $desde , $hasta , $nombreUsuario ,$estado){
            $this->RetrieveData();
            foreach ($this->reservaList as $reserva){
                $pet = $reserva->getPet ();
                $owner = $pet->getOwner();
                if ($reserva->getFechadesde ()== $desde && $reserva->getFechahasta ()==$hasta 
                && $owner->getNombreUser() ==$nombreUsuario ){
                    $reserva->setEstado ($estado);
                    
                }
            }
            
            $this->SaveData();
        }


        
    }

    
?>