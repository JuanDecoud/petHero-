<?php 
    namespace DAO ;

    class TipocuentaDAO {
        private $connection ;
        private $tablaSql = "tipoCuenta";

        public function __construct()
        {
            
        }

       public function getAll (){

         $lista = array ();
         $query = "CALL get_tipoCuenta()";
         $this->connection = Connection::GetInstance();
         $resultado = $this->connection->Execute($query , $lista , QueryType::StoredProcedure);

         foreach($resultado as $fila){
            array_push($lista , $fila['descripcion']);
            
         }

         return $lista ;

       }

    }

?>