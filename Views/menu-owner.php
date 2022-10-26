<?php


    require_once("Header.php");
    require_once ("navOwner.php");
    use DAO\PetDAO;

    $petDao = new PetDAO ();
    $user = $_SESSION['loggedUser'];
    $petlist = $petDao->buscarPets($user->getNombreUser());





?>
   
<div class = "d-flex justify-content-center mt-6 ">
        <div class = "d-flex flex-wrap  col-10  shadow p-3 mb-2 mt-5 bg-body rounded  ">
            <div class = "container  mt-2   col col-10 ">
                <form action="<?php echo FRONT_ROOT."Pet/agregarPet"; ?>" method="post" class ="form-inline  p-2 ">
                    <div class ="d-flex flex-row">
                        <button type="submit" class="btn btn-default btn-sm bg-danger mb-4 ">
                                <span><img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/anadir.png" ?>" alt=""></span> 
                        </button>
                    </div>
                </form>
                <div class="accordion mt-2 " id="accordionExample">
                    <div class="accordion-item mt-2 active">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Mascotas
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class = " d-inline-flex flex-wrap">
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
                                            <img onclick="javascript:this.width=450;this.height=338" ondblclick="javascript:this.width=250;this.height=150" width="250" height = "150" src="<?php echo $pet->getPlanVacunacion()?>" width="100"/>
                                        </div>
                                        <div class="card-body">
                                            <iframe class="embed-responsive-item card-img-top" src="<?php echo $pet->getVideo(); ?>"></iframe>
                                        </div>
                                    </div>
                                    <?php  }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "container col col-10 agregar ">
                <form action="<?php echo FRONT_ROOT."Reserva/listaKeepers"; ?>" method="post" class ="form-inline  p-2 ">
                    <button type="submit" class="btn btn-default btn-sm bg-danger mb-4">
                        <span><img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/recargar.png" ?>" alt=""></span> 
                        
                    </button>
                </form>
            </div>
            <div class = "container  border border-white col col-10 mb-5">
                <div class="accordion  " id="accordion2">
                    <div class="accordion-item active">
                        <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Keepers Disponibles
                        </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion2">
   
                        </div>
                    </div>
                    </div>
                </div>
        </div>
</div>
    
   

   

  


 
<?php require_once("Footer.php"); ?>