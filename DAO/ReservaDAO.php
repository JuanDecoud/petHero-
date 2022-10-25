<?php
    namespace DAO;

    use DAO\IReservaDAO as IReservaDAO;
    use Models\Pet as Pet ;
    use Models\Keeper as Keeper ;
    use Models\Reserva as Reserva;

    class StudentDAO implements IReservaDAO
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
                    $value['nombre']=$pet->getNombre ();
                    $value['raza']=$pet->getRaza ();
                    $value['tamano']=$pet->getTamano ();
                    $value['planVacunacion']=$pet->GetPlanVacunacion ();
                    $value['observacionesGrals']=$pet->getObservacionesGrals ();
                    $value['video']=$pet->getVideo ();
                    $value['imagen']=$pet->getImg ();
                }
                $valuesArray["pet"] = $pet;

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
                    $value ['fechasDisponibles'] = array ();
                    foreach ($keeper->getFechas() as $estadia){
                        $values['desde']=$estadia->getDesde();
                        $values['hasta']=$estadia->getHasta();
                        array_push($value['fechasDisponibles'] , $values); 
                    }
                }
                $valuesArray["keeper"] = $keeper;

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            
            file_put_contents('Data/reserva.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->reservaList = array();
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
                        $keeper = new Keeper(null,null,null,null,null,null,null,null,null);
                        $keeper->setNombreUser( $valuesArray['nombreUser']);
                        $keeper->setContrasena( $valuesArray['contrasena']);
                        $keeper->setTipodecuenta( $valuesArray['tipodeCuenta']);
                        $keeper->setTipoMascota( $valuesArray['tipoMascota']);
                        $keeper->setRemuneracion( $valuesArray['remuneracion']);
                        $keeper->setNombre( $valuesArray['nombre']);
                        $keeper->setApellido( $valuesArray['apellido']);
                        $keeper->setDni( $valuesArray['DNI']);
                        $keeper->setTelefono( $valuesArray['telefono']);
                        $keeper->setFechas( $valuesArray['fechasDisponibles']);
                        
                    }
                        $reserva->setKeeper($keeper); 
                        
                    array_push($this->reservaList, $reserva);
                }
            }
        }
    }
?>