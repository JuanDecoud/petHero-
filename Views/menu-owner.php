<?php

use DAO\KeeperDAO;
use DAO\PetDAO;
use Models\Keeper;

    require_once("Header.php");
    require_once ("navOwner.php");

    $petDao = new PetDAO ();
    $user = $_SESSION['loggedUser'];
    $petlist = $petDao->buscarPets($user->getNombreUser());


    $keeperDao = new KeeperDAO();
    $keeperlist = $keeperDao->getAll();
    $listaEstadias = $keeperDao->listaEstadias($keeperlist);


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
                <form action="<?php echo FRONT_ROOT."Pet/agregarPet"; ?>" method="post" class ="form-inline  p-2 ">
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
                            <div class = " d-inline-flex flex-wrap">
                                <?php foreach ($keeperlist as $keeper){ ?>

                                <?php foreach ($keeper->getFechas() as $estadias){?>
                        <form action="<?php echo FRONT_ROOT."Reserva/prueba" ?>" method = "post">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h7 style= "color:aqua">Disponible</h7>
                                        <h5 class="card-title"><?php echo $keeper->getNombre()." ".$keeper->getApellido(); ?></h5>
                                        <input id="prodId" name="prodId" type="hidden" value="<?php echo $keeper->getNombreUser(); ?>">
                                    </div>
                                    <div class="card-body">
                                        <div class = "col-auto">
                                            <label for="" class = "mx-2 "><h5>Desde:</h5></label>
                                            <input style =" text-align: center; font-weight:bold; color:black; border :0;" class ="border-bottom" type="text" placeholder="<?php echo $estadias->getDesde(); ?>" name ="desde"  value = "<?php echo $estadias->getDesde() ?>"readonly ></td>
                                        </div>
            
                                        <div class = "col-auto" >
                                            <label for="" class = "mx-2 "><h5>Hasta:</h5></label>
                                            <input style =" text-align: center; font-weight:bold; color:black; border:0;" class ="border-bottom" type="text" placeholder="<?php echo $estadias->getHasta() ?>" name ="hasta"  value = "<?php echo $estadias->getHasta() ;?>"readonly ></td>
                                        </div>
                                        <button type="submit" class=" mt-2 btn btn-danger btn-sm ">Reservar</button>
                                    </div>
                                </div>
                            </form>
                                <?php } }?>
                            </div>     
                        </div>
                    </div>
                    </div>
                </div>
        </div>
</div>
    
   

   

  


 
<?php require_once("Footer.php"); ?>