<?php 
    namespace DAO ;
    use Models\Keeper as Keeper ;
    use DAO\OwnerDao as OwnerDao;
    use Models\FechasEstadias as FechasEstadias;
    use Models\Reserva;

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT."Data/keepers.json" ;
        private $keeperList = array ();
       

        public function getAll (){
            $this->obtenerDatos();
            return $this->keeperList;

        }

        public function estadiasPorfecha ($desde , $hasta){
            $keeperlist = array ();
            $listaEstadias = array ();
            $newkeeper = null ;

            $this->obtenerDatos();
       
            foreach ($this->keeperList as $keeper){
                foreach ($keeper->getFechas() as $estadias){
                    if ($estadias->getDesde () >= $desde && $estadias->getHasta () <= $hasta){
                        $newkeeper = $keeper ;
                        array_push ($listaEstadias , $estadias); 
                    }   
                }
                if ($listaEstadias != null){
                    $newkeeper->setFechas ($listaEstadias); 
                    array_push ($keeperlist ,  $newkeeper);
                }
                $listaEstadias = array();
            }
            return $keeperlist;
        }

        public function listaEstadias ($listadeKeepers){
            $listaEstadias = array ();
            foreach ($listadeKeepers as $keeper){
                foreach ($keeper->getFechas() as $estadias){
                    array_push($listaEstadias , $estadias);
                }
            }
            return $listaEstadias;
        }
        
        public function addKeeper (Keeper $keeper){
            
            array_push($this->keeperList , $keeper);
            $this->guardarDatos();
        }


        public function quitarFecha ($username , FechasEstadias $fecha){
            $this->obtenerDatos();
            $nuevoArray  = array ();
            foreach ($this->keeperList as $keeper){
                if ($keeper->getNombreUser()== $username){
                    $arrayFechas = $keeper->getFechas();
                    foreach ($arrayFechas as $estadias){
                        if ($estadias->getDesde()!=$fecha->getDesde() 
                        && $estadias->getHasta()!=$fecha->getHasta() ){
                            array_push($nuevoArray , $estadias); 
                        }
                    }
                    $keeper->setFechas($nuevoArray);
                }
            }
            $this->guardarDatos();
        }

        public function verificarFechadeldia ($desde , $hasta){
            $date = date("Y-m-d");

            if ( $hasta >= $date && $desde>= $date){
                return true;
            }
            else {
                return false ;
            }
        }

        public function verificarRangos ($desde , $hasta  ,$userName){
            $verificar = null ;
            $this->obtenerDatos();
            foreach ($this->keeperList as $keeper){
                if ($keeper->getNombreUser () == $userName){
                    foreach ($keeper->getFechas () as $estadias){
                        if (($desde >= $estadias->getDesde() && $hasta <= $estadias->getHasta()) 
                        || ($desde < $estadias->getDesde () &&  $hasta > $estadias->getHasta()) 
                        || ($desde>=$estadias->getDesde() && $desde<=$estadias->getHasta() && $hasta> $estadias->getHasta() )){
                            
                            $verificar=$estadias ;
                            return $verificar;
                        }
                        else {
                            $verificar = null ;
                            return $verificar ;
                        } 
                    }
                }
            }

        }


        public function buscarEstadias ($nombreUser){
            $this->obtenerDatos();
            $estadiasLista = array ();
            foreach ($this->keeperList as $keeper){
                if ($keeper->getNombreUser () == $nombreUser){
                    foreach ($keeper->getFechas() as $estadias){
                        array_push($estadiasLista , $estadias);
                    }
                }
            }
            return $estadiasLista ;
        }
        public function agregarFecha (FechasEstadias $estadia ,$username ){
            foreach($this->keeperList  as $keeper){
                if ($keeper->getNombreUser()==$username)
                    $keeper->agregarFecha ($estadia);
            }
            $this->guardarDatos();
        }



        public function obtenerUser ($username){
            $user = null ;
            $this->obtenerDatos();
            foreach ($this->keeperList as $keeper){
                if ($keeper->getNombreUser() == $username){
                    $user = $keeper;
                    return $user ;
                }
            }
            return $user ;
        }

        public function comprobarLogin($username , $contrasena){
            $this->obtenerDatos();
            $user = null ;
            foreach ($this->keeperList as $keeper){
                if ($keeper->getNombreUser() == $username && $keeper->getContrasena() == $contrasena ){
                    $user = $keeper ;
                }
            }
            return $user ;
        }

        public function obtenerDatos  (){
            
            if (file_exists($this->fileName)){
                $contenidoJson = file_get_contents($this->fileName);
                $arrayDecodificar = ($contenidoJson) ? json_decode($contenidoJson , true) : array ();
                foreach ($arrayDecodificar as $value ){
                    $keeper = new Keeper($value['nombreUser'] ,$value['contrasena'],$value['tipodeCuenta'],$value['tipoMascota'],$value['remuneracion'],$value['nombre'],$value['apellido'],$value['DNI'],$value['telefono']);
                    foreach ($value['fechasDisponibles'] as $fechas){
                        $estadia= new FechasEstadias($fechas['desde'], $fechas['hasta']);
                        $keeper->agregarFecha($estadia);
                    }
                   /* ///nuevo desde aqui
                    foreach ($value['reservasAceptadas'] as $reserva){
                        $reserva= new Reserva();
                        $keeper->agregarReservaAceptada($reserva);
                    }
                    ///fin*/
                    array_push($this->keeperList , $keeper);
                }
            }
        }

        public function guardarDatos (){
            $arraytoEncode = array ();
            foreach ($this->keeperList as $keeper){
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
               /* ///Nuevo apartir de aqui
                $value ['reservasAceptadas'] = array ();
                foreach ($keeper->getReservas() as $reserva){
                    $values['desde']=$reserva->getFechadesde();
                    $values['hasta']=$reserva->getFechahasta();
                    $values['keeper']=$reserva->getKeeper();
                    $values['pet']=$reserva->getPet();
                    $values['iReserva']=$reserva->getImporteReserva();
                    $values['iTotal']=$reserva->getImporteTotal();
                    array_push($value['reservasAceptadas'] , $values); 
                }
                ///fin*/
                array_push($arraytoEncode , $value);
            }
            $contenidoJson = json_encode($arraytoEncode , JSON_PRETTY_PRINT);
            file_put_contents($this->fileName , $contenidoJson);
        }

    }
?>