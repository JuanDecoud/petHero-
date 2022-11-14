<?php
    namespace DAOSQL;

    use \Exception as Exception;
    use Models\Keeper as Keeper ;
    use DAO\OwnerDao as OwnerDao;
    use Models\FechasEstadias as FechasEstadias;
    use Models\Reserva;
    USE DAO\IKeeperDAO;
use Models\Estadoreserva;

    class KeeperDAO implements IKeeperDAO
    {
        private $connection;
        private $tablename = "keeper";
        private $tableDates = "fechasdisponibles";
        private $tableUser = "user";
        private $keeperList  = array ();

        public function addKeeper(Keeper $keeper)
        {
          
         /*
            $queryUser =  "INSERT INTO " . $this-> tableUser. " (nombreUser, contrasena,tipoDeCuenta,nombre,apellido,dni,telefono)
                                                                VALUES (:nombreUser, :contrasena,:tipoDeCuenta,:nombre,:apellido,:dni,:telefono)";
            $queryKeeper= "INSERT INTO ".$this->tablename." (tipoMascota,remuneracion,idUser) VALUES (:tipoMascota,:remuneracion,:idUserr);";
            
            $queryFechas= "INSERT INTO ". $this->tableDates . " (desde,hasta,idKeeper) VALUES (:desde, :hasta, :idKeeper) ";

            $thirdQuery = "SELECT idUser FROM ". $this->tableUser . " WHERE "." nombreUser = \"". $keeper->getNombreUser()."\"";
            
            $fourthQuery = "SELECT k.idKeeper FROM ". $this->tablename . " k LEFT JOIN " . $this->tableUser." u ON k.idUser = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser()."\"";
            

            $queryKeeper= "INSERT INTO ".$this->tablename." (tipoMascota,remuneracion,idUser) VALUES (:tipoMascota,:remuneracion,:idUserr);";

            $thirdQuery = "SELECT idUser FROM ". $this->tableUser . " WHERE "." nombreUser = \"". $keeper->getNombreUser()."\"";

            */
            
           
                // QUERYS -------------------------------------------------------

                $queryUser = "Call add_user(?,?,?,?,?,?,?)";
                $queryKeeper = "Call add_keeper(?,?)";
                $queryidUser = "CALL buscar_user(?)";
                $queryidKeeper = "Call buscar_keeper(?)";
                $queryTipoMascota = "Call add_tipoMascota(?,?)";

                // parametros User ----------------------------------------------------

                $parametersUser["nombreUser"] = $keeper->getNombreUser();
                $parametersUser["contrasena"] = $keeper->getContrasena();
                $parametersUser["tipoDeCuenta"] = $keeper->getTipodecuenta();
                $parametersUser["nombre"] = $keeper->getNombre();
                $parametersUser["apellido"] = $keeper->getApellido();
                $parametersUser["dni"] = $keeper->getDni();
                $parametersUser["telefono"] = $keeper->getTelefono();
               
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($queryUser, $parametersUser , queryType::StoredProcedure);

                // parametros Keeper---------------------------------------------------   
                $parametersKeeper["remuneracion"] = $keeper->getRemuneracion();
                // busco el id del User 
                $user["nombreUser"] = $keeper->getNombreUser();
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($queryidUser , $user , queryType::StoredProcedure);
            
                foreach ($result as $row){
                    $parametersKeeper["idUser"] = $row[0];
                }
                $this->connection->ExecuteNonQuery($queryKeeper, $parametersKeeper , queryType::StoredProcedure);
               
                //id keeper para agregar el tipo de mascota que cuida 
                $resultadoKeeper = $this->connection->Execute($queryidKeeper ,$user ,queryType::StoredProcedure);
                $idKeeper = null ;
                foreach ($resultadoKeeper as $row){
                    $idKeeper = $row[0];
                }



                // agrego los tipo de mascotas
                $parametroTipomascota['idKeeper'] = $idKeeper;
                $arregloTipomascota = $keeper->getTipo();
                foreach ($arregloTipomascota as $tipoMascota){
                    $parametroTipomascota['tipo_mascota'] = $tipoMascota;
                    $this->connection->ExecuteNonQuery($queryTipoMascota , $parametroTipomascota , queryType::StoredProcedure);
                }    

      
         
/*

                ///Conseguimos el user para el que llenaremos fechas:
                $idUser = $this->connection->Execute($fourthQuery);

                if($keeper -> getFechas() != null){
                    foreach ($keeper->getFechas() as $estadia){
                    $parametersFechas['desde']=$estadia->getDesde();
                    $parametersFechas['hasta']=$estadia->getHasta(); 
                    $parametersFechas['idKeeper']=$idUser["idKeeper"][0];
                    $this->connection->ExecuteNonQuery($queryFechas, $parametersFechas);
                    }
                }
                */
        }



        public function getALL()
        {
            //Crear un arraylist, pushear como en "obtenerUser" y devolver el array.
            $keeperList = array();
            
            try
            {
                // QUERYS 

                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUser = u.idUser ";
               // $queryDates = "SELECT * FROM ". $this->tablename . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper";
                $querytipoMascota = "Call buscar_tipoMascota (?)";
                $queryDates = "CALL buscar_fechasKeeper(?)";
                

                $this->connection = Connection::GetInstance();

                $resultUser = $this->connection->Execute($query);

                foreach($resultUser as $value){
                    $keeper = new Keeper($value['nombreUser'],$value ['contrasena'],$value ['tipoDeCuenta']
                    ,$value ['remuneracion'],$value ['nombre'], $value ['apellido'],$value ['dni'],
                    $value ['telefono']);
                    
                    $nombreuser['nombreUser'] = $keeper->getNombreUser() ;
    
                    // busco los tipos de mascotas que elijio cuidar el keeper
                    $tipoMascota = array();
                    $resultado = $this->connection->Execute($querytipoMascota , $nombreuser,queryType::StoredProcedure);
                    foreach ($resultado as $row){
                        array_push($tipoMascota,$row);
                    }
                    $keeper->setTipoMascota($tipoMascota);

                    //$queryDates = "SELECT * FROM ". $this->tablename . "k JOIN " . $this->tableDates . " d ON k.idKeeper = d.idKeeper"
                    //. "WHERE d.idKeeper= (SELECT k.idKeeper FROM keeper k JOIN user u ON k.idUser = u.idUser WHERE u.nombreUser = \"".$keeper->getNombreUser() . "\")";
                    
                    $nombreUser['nombreUser'] = $keeper->getNombreUser();
                    $result = $this->connection->Execute($queryDates , $nombreUser ,queryType::StoredProcedure);
                    if($result){
              
                    foreach($result as $fecha){
                        $fechaResultado = new FechasEstadias($fecha["desde"],$fecha["hasta"]);
                        $keeper->agregarFecha($fechaResultado);
                    }
                
                 
                    array_push($this->keeperList,$keeper);
                }

            }
        }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
            return $this->keeperList;
            
        }

        public function obtenerUser($username){
            $theKeeper = null;

            try{
                
                /*$query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUser = u.idUser ". "WHERE u.nombreUser = \"". $username ."\"";*/
                
                $query = "Call buscar_keeper(?)";
                $parametro ['userName'] = $username ;

               
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query , $parametro ,QueryType::StoredProcedure);

                $querytipoMascota = "Call buscar_tipoMascota (?)";

               

                foreach ($resultSet as $row)
                {  
                              
                    $theKeeper = $row[0];
                    
                }
                
                /// agrego el tipo de mascota 
                    if ($theKeeper !=null){
                        $nombreUser['nombreUser'] = $theKeeper->getNombreUser();
                        $tipoMascota = array();
                        $resultado = $this->connection->Execute($querytipoMascota , $nombreUser,queryType::StoredProcedure);
                        foreach ($resultado as $row){
                            array_push($tipoMascota,$row);
                        }
                        $theKeeper->setTipoMascota($tipoMascota);
                    }

                


            }catch(Exception $ex){
                throw $ex;
            }
            
            return $theKeeper;
        }

        public function comprobarLogin($username, $contrasena){
            $user = null;

            try{
                
                $query = "SELECT * FROM ". $this->tablename. " k JOIN ". $this->tableUser. " u ON k.idUser = u.idUser WHERE u.nombreUser = \"". $username ."\"" ." AND u.contrasena = \"" .$contrasena."\"";

                $querytipoMascota = "Call buscar_tipoMascota (?)";

                $nombreuser['nombreUser'] = $username ;
                $this->connection = Connection::GetInstance();

                // busco los tipos de mascotas que elijio cuidar el keeper

                $tipoMascota = array();
                $resultado = $this->connection->Execute($querytipoMascota , $nombreuser,queryType::StoredProcedure);
                foreach ($resultado as $row){
                    array_push($tipoMascota,$row);
                }


                // datos user 
                $resultSet = $this->connection->Execute($query);

                if($resultSet){
                    foreach ($resultSet as $row)
                    {            
                      $user = new Keeper($row["nombreUser"],$row["contrasena"],$row["tipoDeCuenta"],$row["remuneracion"],$row["nombre"],$row["apellido"],$row["dni"],$row["telefono"]);
                    
                    }
                    $user->setTipoMascota($tipoMascota);
                    
                }
                
            }catch(Exception $ex){
                throw $ex;
            }
            
            return $user;
        }

        public function agregarFecha(FechasEstadias $estadia, $username){
                
            $dateDesde = date_create($estadia -> getDesde());
            $dateHasta = date_create($estadia -> getHasta());

            try{
                /*
                $query = "INSERT INTO ". $this->tableDates . " (desde,hasta,idKeeper,estado) VALUES " . "(\"".date_format($dateDesde,"Y/m/d")."\",\"".date_format($dateHasta,"Y/m/d")."\",\"".Estadoreserva::Activo."\"".
                "(SELECT k.idKeeper FROM keeper k JOIN user u on k.idUser = u.idUser WHERE u.nombreUser = \"". $username . "\"))";*/
                $queryRango = "CALL agregar_rango (?,?,?,?)";
                $queryKeeper = "Call buscar_keeper(?)";

                $this->connection = Connection::GetInstance();

                $parametros['desde'] = date_format($dateDesde,"Y/m/d");
                $parametros ['hasta'] =date_format($dateHasta,"Y/m/d");
                $user['userName'] = $username ;
                $result = $this->connection->Execute($queryKeeper , $user , queryType::StoredProcedure);
                foreach ($result as $row){
                    $parametros['idKeeper'] = $row[0];
                }
                $parametros['estado'] = Estadoreserva::Activo;

                $this->connection->ExecuteNonQuery($queryRango , $parametros , QueryType::StoredProcedure);

                
            } catch (Exception $ex){
                throw $ex;
            }
            
        }

        public function verificarRangos ($desde , $hasta  ,$userName){
            $verificar = null ;
            
            $fechaDesde = $desde ;
            $fechaHasta = $hasta ;

            try{
                
                $queryFechas = "CALL buscar_fechasKeeper(?)";
                $parametro['userName']= $userName ;

                $this->connection = Connection::GetInstance();

                $resultado = $this->connection->Execute($queryFechas , $parametro , QueryType::StoredProcedure);

                foreach ($resultado as $row){
        
                    if ( ($desde>=$row[0] && $desde<=$row[1] && $hasta> $row[1] )
                        || ($desde <= $row[0] && $hasta >= $row[1])
                        || ($desde <= $row[0] && $hasta <= $row[1] && $hasta >=$row[1])
                        || ($desde <= $row[0] && $hasta >= $row[0] && $hasta <=$row[1])){
                            $estadia  = new FechasEstadias($row[0] , $row[1]);
                            $verificar=$estadia ;
                            return $verificar;
                        }
                        else { 
                            $verificar = null ;
                        } 
                }
                
            }
            catch (Exception $ex) {
                throw $ex ;
            }

            echo $verificar;
            return $verificar;

        }



        public function quitarFecha ($username , FechasEstadias $fecha){
            $fecDesde =  date_create($fecha->getDesde());
            $fecHasta =  date_create($fecha->getHasta());

            try
            {
                $query="DELETE FROM ". $this->tableDates. " WHERE desde = \"". date_format($fecDesde,"Y/m/d")."\" AND hasta = \"". date_format($fecHasta,"Y/m/d"). "\""
                ."AND idKeeper = ". "(SELECT k.idKeeper from keeper k JOIN user u ON u.idUser = k.idUser WHERE u.nombreUser = \"". $username."\")";
            
                $this->connection = Connection::GetInstance();

                $this->connection->Execute($query);    
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
        }

        public function buscarEstadias ($nombreUser){
            $estadiasLista = array ();

            try
            {
                // se buscan los datos de la estadia

                $query= "SELECT * FROM ". $this->tableDates. 
                " f JOIN keeper k ON f.idKeeper = k.idKeeper
                JOIN user u ON k.idUser = u.idUser
                WHERE u.nombreUser = \"". $nombreUser. "\"";

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);  
                
          
                $queryKeeper = "CALL buscar_datosUser(?)";
                $user['nombreUsuario'] = $nombreUser;
                $datosKeeper = $this->connection->Execute($queryKeeper , $user , queryType::StoredProcedure);
                $keeper = null;


                foreach($resultSet as $fecha){
                    $date = new FechasEstadias($fecha["desde"],$fecha["hasta"]);
                    $date->setEstado($fecha['estado']);
                    array_push($estadiasLista,$date);
                }

            }
            catch (Exception $ex)
            {
                throw $ex;
            }


            return $estadiasLista;


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

        public function estadiasPorfecha ($desde , $hasta){
            
            $this->getALL();
            $keeperlist = array ();
            $listaEstadias = array ();
            $newkeeper = null ;
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


  
    }
       
    
?>