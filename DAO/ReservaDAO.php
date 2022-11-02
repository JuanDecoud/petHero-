<?php
    namespace DAO;

    use DAO\IReservaDAO as IReservaDAO;
    use Models\Pet as Pet ;
    use Models\Keeper as Keeper ;
    use Models\Reserva as Reserva;

    class ReservaDAO implements IReservaDAO
    {
        private $reservaList = array();

        public function Add(Reserva $reserva)
        {
            $this->RetrieveData();
            
            array_push($this->reservaList, $reserva);

            $this->SaveData();
        }

        public function GetAll()
        {
            $this->RetrieveData();

            return $this->reservaList;
        }

        public function buscarReservas (Keeper $keeper){
            $this->RetrieveData();
            $listadeReservas = array();
            foreach ($this->reservaList as $reserva ){
                $keeperReserva = $reserva->getKeeper();
                if($keeperReserva->getNombreUser()==$keeper->getNombreUser()){
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
                    $reserva->setFechadesde($valuesArray["fdesde"]);
                    $reserva->setFechahasta($valuesArray["fhasta"]);
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
                        
                    }

                    $reserva-> setPet($pet);

                    if($valuesArray["keeper"] != null){
                        $keeper = new Keeper($valuesArray["keeper"]['nombreUser'],$valuesArray["keeper"]['contrasena'], $valuesArray["keeper"]['tipodeCuenta'],$valuesArray["keeper"]['tipoMascota'],$valuesArray["keeper"]['remuneracion'],$valuesArray["keeper"]['nombre'],$valuesArray["keeper"]['apellido'],$valuesArray["keeper"]['DNI'],$valuesArray["keeper"]['telefono']);

                    }
                        $reserva->setKeeper($keeper); 
                        
                    array_push($this->reservaList, $reserva);
                }
            }
        }

        public function borrarReservaxNombre($nombreKeeper, $nombrePet){
            $this -> RetrieveData();

            $keeper = null;
            $pet = null;
            foreach($this-> reservaList as $reserva){
                $keeper = $reserva->getKeeper();
                $pet = $reserva -> getPet();
                if($keeper -> getNombreUser() == $nombreKeeper && $pet ->getNombre() == $nombrePet){
                    $this -> borrarReserva($reserva);
                }
            }
     
        }

        private function borrarReserva(Reserva $reserva){
            
            if(($clave = array_search($reserva, $this->reservaList) !== false)){
                unset($this -> reservaList[$clave]);
            }

            $this -> SaveData();
        }
    }
?>