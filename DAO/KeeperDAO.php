<?php 
    namespace DAO ;
    use Models\Keeper as Keeper ;
    
    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT."Data/keepers.json" ;
        private $keeperList = array ();

        public function getAll (){
            $this->obtenerDatos();
            return $this->keeperList ;
        }
        
        public function addKeeper (Keeper $keeper){
            $this->obtenerDatos() ;
            
            array_push($this->keeperList , $keeper);
            $this->guardarDatos();
        }


        public function agregarFecha ($fecha ){
            
            $this->obtenerDatos();
            foreach($this->keeperList  as $keeper){
                $keeper->agregarFecha ($fecha);
            }
           
            $this->guardarDatos();

        }



        public function obtenerUser ($username , $contrasena){
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
                    $keeper = new Keeper($value['nombreUser'] ,$value['contrasena'],$value['tipodeCuenta'],$value['tipoMascota'],$value['remuneracion']  );
                    $keeper->setFechas($value['fechasDisponibles']);
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
                $value ['remuneracion'] = $keeper->getRemuneracion ();
                $value ['fechasDisponibles'] = array ();
                foreach ($keeper->getFechas() as $fechas){
                    array_push($value['fechasDisponibles'] , $fechas);
                }
                array_push($arraytoEncode , $value);

            }

            $contenidoJson = json_encode($arraytoEncode , JSON_PRETTY_PRINT);
            file_put_contents($this->fileName , $contenidoJson);
        }

    }
?>