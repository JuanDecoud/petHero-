<?php


    require_once("Header.php");
    require_once ("navOwner.php");
    use DAO\PetDAO;
use DAO\ReservaDAO;

    $petDao = new PetDAO ();
    $user = $_SESSION['loggedUser'];
    $petlist = $petDao->buscarPets($user->getNombreUser());
    $reservadao = new ReservaDAO();
    $listaAceptada = $reservadao->buscarReservaAceptada($user->getNombreUser());





?>
   
<div class = "d-flex justify-content-center mt-6 col-10 mx-auto  ">
    
        <div class = "d-flex flex-wrap  col-12  shadow p-3 mb-2 mt-5 bg-body rounded border border-secondary ">
            <div class = "container-fluid ">
                 <h4 class ="border-bottom col-2" >Menu Principal</h4>
            </div>
            <div class = "container  col col-10 mt-4">
                <form action="<?php echo FRONT_ROOT."Pet/agregarPet"; ?>" method="post" class ="form-inline  p-2 ">
                    <div class ="d-flex flex-row">
                        <button type="submit" class="btn btn-default btn-sm bg-danger mb-4 ">
                                <span><img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/anadir.png" ?>" alt=""></span> 
                        </button>
                    </div>
                </form>
                <div class="accordion  " id="accordionExample">
                    <div class="accordion-item  active">
                        <h2 class="accordion-header " id="headingOne">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Mascotas
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class = " d-inline-flex flex-wrap">
                                <?php foreach ($petlist as $pet){ ?>
                                    <div class="card m-3 " style="width: 18rem;">
                                        <img src="<?php echo $pet->getImg(); ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $pet->getNombre(); ?></h5>
                                            <p class="card-text"><?php echo $pet->getObservacionesGrals()?></p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Tamaño:</strong><?php echo"  ". $pet->getTamano();?></li>
                                            <li class="list-group-item"><strong>Raza:</strong><?php echo "  ". $pet->getRaza();?></li>
                                        </ul>
                                    </div>
                                    <?php  }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "container  ">
                <div class="accordion  " id="accordio3">
                        <div class="accordion-item mt-5 active">
                            <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                Pendientes de pago 
                            </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordio3">
                                <div class = " d-inline-flex flex-wrap">
                                    <?php foreach ($listaAceptada as $reserva){ 
                                        $pet = $reserva->getPet();
                                        ?>
                                    <form action="">
                                        <div class="card m-3 " style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">Estadia</h5>
                                            </div>
                                            <img src="<?php echo $pet->getImg(); ?>" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $pet->getNombre(); ?></h5>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><strong>Desde:</strong><?php echo $reserva->getFechadesde(); ?></li>
                                                <li class="list-group-item"><strong>Hasta:</strong><?php echo $reserva->getFechahasta();?></li>
                                            </ul>
                                            <div class="card-body">
                                                <button type = "button" class = "btn-sm btn-danger">Pagar</button>
                                            </div>
                                            
                                        </div>
                                    </form>
                                        <?php  }?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class = "d-inline-flex mx-auto col-10 agregar  justify-content-around  ">
                <div class = "d-flex col-2  justify-content-start  ">
                    <form action="<?php echo FRONT_ROOT."Reserva/listaKeepers"; ?>" method="post">
                        <button type="submit" class="btn btn-default btn-sm mt-4 mx-4  bg-danger">
                            <img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/recargar.png" ?>" alt="">
                        </button>
                    </form>
                </div>
                <form class="row g-5 d-flex justify-content-end " method = "post" action="<?php echo FRONT_ROOT."Reserva/keepersPorfecha" ;?>">
                        <div class = "d-inline-flex  col-9   ">
                            <input type="text" readonly class="form-control-plaintext text-center mt-4" id="" value="Desde">
                            <input type="date" class="form-control mt-4" id="" placeholder="" name="desde" required>
                            <input type="text" readonly class="form-control-plaintext text-center mt-4" id="" value="Hasta">
                            <input type="date" class="form-control mt-4" id="" placeholder="" name="hasta" required>
                            <button  type ="submit"class = "btn btn-sm btn-danger mx-4 mt-4">Buscar</button>
                        </div>
                </form>
            </div>
            <div class = "container  col col-10 mb-5 mt-4  ">
                <div class="accordion  " id="accordion2">
                    <div class="accordion-item active">
                        <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Keepers Disponibles
                        </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show " aria-labelledby="headingTwo" data-bs-parent="#accordion2">
   

 
<?php require_once("Footer.php"); ?>