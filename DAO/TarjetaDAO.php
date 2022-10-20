<?php

    use DAO\ITarjetaDAO as ITarjetaDAO;
    use Models\Tarjeta as Tarjeta;
    

    class TarjetaDao implements ITarjetaDAO
    {
        private $tarjetaList;

        public function Add(Tarjeta $tarjeta)
        {
            $this->RetrieveData();
            array_push($this->tarjetaList, $tarjeta);
        }
        public function GetAll()
        {
            $this->RetrieveData();
            return $this->tarjetaList;
        }
        private function SaveData()
        {
            $arrayToEncode=array();
            foreach($this->tarjetaList as $tarjeta)
            {
                $valuesArray["numero"]=$tarjeta->getNumero();
                $valuesArray["nombre"]=$tarjeta->getNombre();
                $valuesArray["fechaVenc"]=$tarjeta->getFechaVenc();
                $valuesArray["codigo"]=$tarjeta->getCodigo();

                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent= json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents('Data\tarjeta.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->tarjetaList=array();
            if(file_exists('Data/tarjeta.json'))
            {
                $jsonContent=file_get_contents('Data/tarjeta.json');
                $arrayToDecode=($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $tarjeta=new Tarjeta($valuesArray["numero"], $valuesArray["nombre"],$valuesArray["fechaVenc"], 
                    $valuesArray["codigo"]);
                    /*$tarjeta->setNumero($valuesArray["numero"]);
                    $tarjeta->setNombre($valuesArray["nombre"]);
                    $tarjeta->setFechaVenc($valuesArray["fechaVenc"]);
                    $tarjeta->setCodigo($valuesArray["codigo"]);*/

                    array_push($this->tarjetaList, $tarjeta);
                    
                }
            }
        }
    }

?>