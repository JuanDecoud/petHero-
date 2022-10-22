<?php

use DAO\PetDAO;

    require_once("Header.php");
    require_once ("navOwner.php");

    $petDao = new PetDAO ();
    $user = $_SESSION['loggedUser'];
    $petlist = $petDao->buscarPets($user->getNombreUser());
?>
   
<div class = "d-flex  mt-5 border border-black">
    <div class = "container ">
        <div class = "d-flex flex-wrap  col-10 flex-column shadow p-3 mb-5 mt-5 bg-body rounded">
            <div class = "container mt-5   col col-10 ">
                <form action="<?php echo FRONT_ROOT."Pet/agregarPet"; ?>" method="post" class ="form-inline  p-2 ">
                        <button type="submit" class="btn btn-default btn-sm bg-danger mb-4 ">
                            <span><img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/anadir.png" ?>" alt=""></span> 
                            <span><strong>Agregar Mascota</strong></span>
                        </button>
                </form>
                <div class="accordion mt-2 " id="accordionExample">
                    <div class="accordion-item mt-2 active">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Mascotas
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class = " d-inline-flex">
                            <?php foreach ($petlist as $pet){ ?>
                                <div class="card" style="width: 18rem;">
                                    <img src="<?php echo $pet->getImg(); ?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $pet->getNombre(); ?></h5>
                                        <p class="card-text"><?php echo $pet->getObservacionesGrals()?></p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Tamaño:</strong><?php echo"  ". $pet->getTamano();?></li>
                                        <li class="list-group-item"><strong>Raza:</strong><?php echo "  ". $pet->getRaza();?></li>
                                    </ul>
                                    <div class="card-body">
                                        <a href="#" class="card-link">Plan de Vacunacion</a>
                                    </div>
                                </div>
                                <?php  }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "container col col-10 agregar ">
                <form action="<?php echo FRONT_ROOT."Pet/agregarPet"; ?>" method="post" class ="form-inline  p-2 ">
                    <button type="submit" class="btn btn-default btn-sm bg-danger mb-4">
                        <span><img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/anadir.png" ?>" alt=""></span> 
                        <span><strong>Actualizar Lista</strong></span>
                    </button>
                </form>
            </div>
            <div class = "container mt-2 border border-white col col-10">
                <div class="accordion mt-2 " id="accordion2">
                    <div class="accordion-item mt-2 active">
                        <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Keepers Disponibles
                        </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            
                        </div>
                    </div>
                    </div>
                </div>
        </div>

        </div>
        <div>
            <p class ="bg-bg"></p>
        </div>

</div>
    
   

   

  


 
<?php require_once("Footer.php"); ?>