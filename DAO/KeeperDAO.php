<?php 
    namespace DAO ;
    use Models\Keep as Keep ;
    
    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT."Data/keepers.json" ;
        private $keeperList = array ();

        public function getAll (){
            return $this->keeperList ;
        }
        
        public function addKeeper (Keep $keeper){
            $this->obtenerDatos() ;
            
            array_push($this->keeperList , $keeper);
            $this->guardarDatos();
        }



        public function __construct()
        {
            
        }

        public function obtenerDatos  (){
            if (file_exists($this->fileName)){
                $contenidoJson = file_get_contents($this->fileName);
                $arrayDecodificar = ($contenidoJson) ? json_decode($contenidoJson , true) : array ();
                foreach ($arrayDecodificar as $value ){
                    $keeper = new Keep($value['nombreUser'] ,$value['contrasena'],$value['tipodeCuenta'],$value['tipoMascota'],$value['remuneracion']  );
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
                array_push($arraytoEncode , $value);

            }

            $contenidoJson = json_encode($arraytoEncode , JSON_PRETTY_PRINT);
            file_put_contents($this->fileName , $contenidoJson);
        }

    }
?>