<?php

use Models\Keeper;

    require_once("Header.php");
    require_once("nav.php");
    use DAO\KeeperDAO as KeeperDAO ;

    $keepDao = new KeeperDao();
    $arrayKeepers = $keepDao->getAll();
    $fechas = array();
    foreach ($arrayKeepers as $keeper){
        foreach($keeper->getFechas() as $fecha){
            array_push ($fechas , $fecha);
        }
    }
    
 
?>

<div class = "container mt-5  border border-white">
    <div class ="d-flex  flex-row  justify-content-around">
        <form action="<?php echo FRONT_ROOT."Register/asignarFecha"; ?>" method="post" class ="form-group mr-auto p-2 ">
            <h4 class = "my-2">Agregar Disponibilidad</h4>
            <input  class ="calendar my-4" type="date" name="fecha" placeholder="" >
            <div >
                <button type="submit" class="btn btn-default btn-sm bg-danger mb-4">
                    <span><img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/anadir.png" ?>" alt=""></span> 
                </button>
            </div>
        </form>
        <div>
            <h4>Fechas Seleccionadas</h4>
            <table class ="table bg bg-dark text-white">
                <thead>
                    <tr>
                        <th scope ="col">Fecha</th>
                    </tr>
                   
                </thead>
                <tbody>
                    <?php foreach ($fechas as $fechasKeeper ) { 
                                                             ?>
                    <tr>
                        <td><?php  echo $fechasKeeper;?></td>
                    </tr>

                    <?php }?>
                </tbody>

            </table>

        </div>
      
        
    </div>
    

</div>


<div class = "container mt-5 border border-white col col-10">
    <div class="accordion mt-5" id="accordionExample">
        <div class="accordion-item mt-5">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Estadias Solicitadas
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
            
            </div>
            </div>
        </div>
        <div class="accordion-item mt-5 mb-5">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Estadias Aceptadas 
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
            </div>
            </div>
        </div>
    </div>
</div>



<?php require_once ("Footer.php"); ?>