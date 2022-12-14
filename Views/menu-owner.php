
   
<div class = "d-flex justify-content-center mt-10 col-11 mx-auto  ">
    
        <div class = "d-flex flex-wrap f col-12  shadow p-3 mb-2 mt-5 bg-body rounded border border-secondary ">
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
                            
                                <?php foreach ($petlist as $pet){ ?>
                                <div class = " d-inline-flex flex-wrap">
                                    <div class="card m-3 " style="width: 18rem;">
                                        <img src="<?php echo $pet->getImg(); ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $pet->getNombre(); ?></h5>
                                            <p class="card-text"><?php echo $pet->getObservacionesGrals()?></p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Tama??o:</strong><?php echo"  ". $pet->getTamano();?></li>
                                            <li class="list-group-item"><strong>Raza:</strong><?php echo "  ". $pet->getRaza();?></li>
                                        </ul>
                                        <div class="card-body">
                                            <img onclick="javascript:this.width=450;this.height=338" ondblclick="javascript:this.width=250;this.height=150" width="250" height = "150" src="<?php echo $pet->getPlanVacunacion()?>" width="100"/>
                                        </div>
                                        <div class="card-body">
                                            <iframe class="embed-responsive-item card-img-top" src="<?php echo $pet->getVideo(); ?>"></iframe>
                                        </div>


                                    </div>
                                    
                                </div>
                                <?php  }?>
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
                            <div id="collapse3" class="accordion-collapse collapse show" aria-labelledby="heading3" data-bs-parent="#accordio3">
                               
                                <?php foreach ($listaAceptada as $reserva){ 
                                    $pet = $reserva->getPet();
                                    $keeper = $reserva->getKeeper ();
                                    ?>
                                <div class = " d-inline-flex flex-wrap">
                                    <form action="<?php echo FRONT_ROOT."Reserva/simulacionPago"; ?>" method ="post">
                                        <div class="card m-3 " style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">Estadia</h5>
                                            </div>
                                            <img src="<?php echo $pet->getImg(); ?>" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title"><input style=" text-align: center; font-weight:bold; color:black; border :0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getNombre();?>" name="pet" value="<?php echo $pet->getNombre();?>" readonly></h5>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                            
                                                <?php foreach ($reserva->getDias() as $dias ) { ?>
                                                <li class="list-group-item"><?php echo $dias?></td></li>
                                                <?php }?>

                                                <li class="list-group-item"><strong>Keeper:</strong><input style=" text-align: center; color:black; border:0;"  type="text" placeholder="<?php echo $keeper->getNombreUser(); ?>" name="keeper" value="<?php echo $keeper->getNombreUser(); ?>" readonly></li>

                                                <li class="list-group-item"><strong>Costo:</strong><input style=" text-align: center; color:black; border:0;"  type="text" placeholder="$<?php echo $keeper->getNombreUser(); ?>" name="importe" value="<?php echo $reserva->getImporteReserva(); ?>" readonly></li>
                                            </ul>
                                            <div class="card-body">
                                                <button type = "submit" class = "btn-sm btn-danger">Pagar</button>
                                            </div>
                                    </form>
                                </div>
                                <?php  }?>
                            </div>
                        </div>
                </div>
            </div>
        <div class = "container">
            <div class="accordion  " id="accordio4">
                    <div class="accordion-item mt-5 active">
                        <h2 class="accordion-header" id="heading4">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                            Estadia en curso
                        </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse show" aria-labelledby="heading4" data-bs-parent="#accordio4">
                            
                                <?php foreach ($ListaEnCurso as $reserva){ 
                                    $pet = $reserva->getPet();
                                    $keeper = $reserva->getKeeper();
                                    ?>
                            <div class = " d-inline-flex flex-wrap">
                                <form action="<?php echo FRONT_ROOT."Review/simulacionPago"?>" method ="post">
                                    <div class="card m-3 " style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Estadia</h5>
                                        </div>
                                        <img src="<?php echo $pet->getImg(); ?>" class="card-img-top" alt="...">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Nombre:<input style=" text-align: center; color:black; border:0;"  type="text" placeholder="<?php echo $pet->getNombre(); ?>" name="pet" value="<?php echo $pet->getNombre(); ?>" readonly></li> 
                                            <li class="list-group-item">Cuidador:<input style=" text-align: center; color:black; border:0;"  type="text" placeholder="<?php echo $keeper->getNombreUser(); ?>" name="keeper" value="<?php echo $keeper->getNombreUser(); ?>" readonly></li>
                                            <?php foreach ($reserva->getDias() as $dias ) { ?>
                                                <li class="list-group-item"><input style=" text-align: center; font-weight:bold; color:black; border :0;" class="border-bottom" type="text" placeholder="<?php echo $dias?>" name="arreglo[]" value="<?php echo $dias?>" readonly></td></li>
                                                <?php }?>
                                        </ul>
                                        <div class="card-body">
                                            <button type = "submit" class = "btn-sm btn-danger">Completar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php  }?>
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
                            <input type="date" class="form-control mt-4" id="" placeholder="" name="desde" required min ="<?php $hoy = date("Y-m-d"); echo $hoy ?>">
                            <input type="text" readonly class="form-control-plaintext text-center mt-4" id="" value="Hasta">
                            <input type="date" class="form-control mt-4" id="" placeholder="" name="hasta" required min ="<?php $hoy = date("Y-m-d"); echo $hoy ?>"> 
                            <button  type ="submit"class = "btn btn-sm btn-danger mx-4 mt-4">Buscar</button>
                        </div>
                </form>
            </div>

            
            <div class="accordion mt-2 mb-4 " id="accordion2">
                    <div class="accordion-item active">
                        <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed bg bg-danger " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Keepers Disponibles
                        </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show " aria-labelledby="headingTwo" data-bs-parent="#accordion2">


 
