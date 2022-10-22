<?php

use DAO\PetDAO;

    require_once("Header.php");
    require_once ("navOwner.php");

    $petDao = new PetDAO ();
    $user = $_SESSION['loggedUser'];
    $petlist = $petDao->buscarPets($user->getNombreUser());
?>
   
    <div class = "container col col-10 agregar ">
         <form action="<?php echo FRONT_ROOT."Pet/agregarPet"; ?>" method="post" class ="form-inline  p-2 ">
            <button type="submit" class="btn btn-default btn-sm bg-danger mb-4">
                <span><img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/anadir.png" ?>" alt=""></span> 
                <span><strong>Agregar Mascota</strong></span>
            </button>
        </form>
    </div>

    <div class = "container mt-5 border border-white col col-10">
        <div class="accordion mt-5 " id="accordionExample">
            <div class="accordion-item mt-5 active">
                <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    Mascotas
                </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
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
    </div>
</div>
   


 
<?php require_once("Footer.php"); ?>