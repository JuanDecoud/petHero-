<?php 
    namespace DAO ;
    use Models\Keeper as Keeper ;
    use DAO\OwnerDao as OwnerDao;
    use Models\FechasEstadias as FechasEstadias;

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT."Data/keepers.json" ;
        private $keeperList = array ();
        private $ownerList = array();

        public function getAll (){
            $this->obtenerDatos();
            return $this->keeperList;
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


        public function agregarFecha (FechasEstadias $estadia ,$username ){
            
            $this->obtenerDatos();
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
                array_push($arraytoEncode , $value);
            }
            $contenidoJson = json_encode($arraytoEncode , JSON_PRETTY_PRINT);
            file_put_contents($this->fileName , $contenidoJson);
        }

    }
?>