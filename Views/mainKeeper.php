<?php

use Models\Keeper;

    require_once("Header.php");
    require_once("navKeeper.php");
    use DAO\KeeperDAO as KeeperDAO ;

    $keepDao = new KeeperDao();
    $userLogged = $_SESSION['loggedUser'];
    $user= $keepDao->obtenerUser($userLogged->getNombreUser());
    $fechas = $user->getFechas();

?>

<div class = "container mt-5  border border-white">
    <div class ="d-flex  flex-row  justify-content-around">
        <form action="<?php echo FRONT_ROOT."Keeper/asignarFecha"; ?>" method="post" class ="form-group mr-auto p-2 ">
            <h4 class = "my-2">Agregar Disponibilidad</h4>
            <input  class ="calendar my-4" style ="border 2px solid" type="date" name="desde" placeholder="" required >
            <div >
            </div>
            <input  class ="calendar my-4" style ="border 2px solid" type="date" name="hasta" placeholder="" required >
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
                        <th scope ="col">Desde</th>
                        <th scope ="col">Hasta</th>
                    </tr>
                   
                </thead>
                <tbody>
                    <?php foreach ($fechas as $fechasKeeper ) { 
                                                             ?>
                    <tr>
                        <form action="<?php echo FRONT_ROOT."Keeper/quitarFecha" ?>" method="post">
                            <td ><input style =" text-align: center; font-weight:bold; color:black;" type="text" placeholder="<?php  echo $fechasKeeper->getDesde();?>" name ="desde"  value = "<?php  echo $fechasKeeper->getDesde();?>"readonly ></td>
                            <td>
                                <input style =" text-align: center; font-weight:bold; color:black;" type="text" placeholder="<?php  echo $fechasKeeper->getHasta();?>" name ="hasta"  value = "<?php  echo $fechasKeeper->getHasta();?>"readonly >
                            </td>
                            <td>
                                <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                            </td>
                        </form>
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