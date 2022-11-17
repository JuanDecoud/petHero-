

<div class="container mt-5   shadow p-3 mb-5 bg-ligh rounded">
    <div class="d-flex  flex-row  justify-content-around">
        <form action="<?php echo FRONT_ROOT . "Keeper/asignarFecha"; ?>" method="post" class="form-group mr-auto p-2 shadow p-3 mb-5 bg-ligh rounded ">
            <h4 class="my-2">Agregar Disponibilidad</h4>
            <div class="col-auto mx-auto">
                <label for="" class="mx-2">
                    <h5>Desde:</h5>
                </label>
                <input class="calendar my-4 col-8" style="border: 2px solid;" type="date" name="desde" placeholder="" required min ="<?php $hoy = date("Y-m-d"); echo $hoy ?>">
            </div>

            <div class="col-auto mx-auto">
                <label for="" class="mx-2">
                    <h5>Hasta:</h5>
                </label>
                <input class="calendar my-4 col-8" style="border: 2px solid" type="date" name="hasta" placeholder="" required min ="<?php $hoy = date("Y-m-d"); echo $hoy ?>">
            </div>

            <div>
                <button type="submit" class="btn btn-default btn-sm bg-danger mb-4">
                    <span><img src="<?php echo FRONT_ROOT . VIEWS_PATH . "img/anadir.png" ?>" alt=""></span>
                </button>
            </div>
        </form>
        <div class="shadow p-3 mb-5 bg-ligh rounded">
            <h4>Fechas Seleccionadas</h4>
            <table class="table bg bg-dark text-white">
                <thead>
                    <tr>
                        <th scope="col">Desde</th>
                        <th scope="col">Hasta</th>
                    </tr>

                </thead>
                <tbody>
                    <?php foreach ($fechas as $fechasKeeper) {
                    ?>
                        <tr>
                            <form action="<?php echo FRONT_ROOT . "Keeper/quitarFecha" ?>" method="post">
                                <td><input style=" text-align: center; font-weight:bold; color:black;" class="" type="text" placeholder="<?php echo $fechasKeeper->getDesde(); ?>" name="desde" value="<?php echo $fechasKeeper->getDesde(); ?>" readonly></td>
                                <td>
                                    <input style=" text-align: center; font-weight:bold; color:black;" type="text" placeholder="<?php echo $fechasKeeper->getHasta(); ?>" name="hasta" value="<?php echo $fechasKeeper->getHasta(); ?>" readonly>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                                </td>
                            </form>
                        </tr>

                    <?php } ?>
                </tbody>

            </table>

        </div>
    </div>
    <div class = "d-inline-flex justify-content-between justify-content-end">
        <form  class = "m-2 "action="<?php echo FRONT_ROOT."Review/historico"; ?>" method ="get">
            <button type="submit" class="btn btn-danger btn-md ">Reviews</button>
        </form>
        <form  class = "m-2"action="<?php echo FRONT_ROOT."Reserva/reservasCompletadas"; ?>" method ="get">
            <button type="submit" class="btn btn-danger btn-md ">Historico</button>
        </form>
    </div>
</div>

<div class = "container shadow p-3 mb-5 bg-ligh rounded">
    <div class="accordion mt-5" id="accordion2">
            <div class="accordion-item mt-5">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed bg bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Estadias Solicitadas
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordion2">
                    <div class="accordion-body  ">            
                        <?php foreach ($listaReservas as $reserva) {
                                $pet = $reserva->getPet();
                                $owner = $pet->getOwner ()?>  
                            <div class="d-inline-flex flex-wrap ">
                                <div class="card m-2" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="border-bottom">Solicitud de estadia.</h5>
                                    <div class = "container mt-3">
                                        <h6 >Fechas solicitadas</h6>
                                    </div>
                                    <form action="<?php echo FRONT_ROOT . "Reserva/aceptarReserva" ?>">
                                        <div class="col-auto mt-2">
                                            <input type="hidden" value = "<?php echo  $owner->getNombreUser(); ?>" name = "owner">
                                            <input type="hidden" value = "<?php echo $pet->getNombre(); ?>" name = "pet">
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($reserva->getDias() as $dias ) { ?>
                                            <li class="list-group-item"><input style=" text-align: center; font-weight:bold; color:black; border :0;" class="border-bottom" type="text" placeholder="<?php echo $dias?>" name="arreglo[]" value="<?php echo $dias?>" readonly></td></li>
                                            <?php }?>
                                        </ul>

                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Raza</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getRaza();  ?>" name="raza" value="<?php  ?>" readonly></td>
                                        </div>
                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Tamaño:</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getTamano(); ?>" name="tamano" value="<?php echo $pet->getTamano(); ?>" readonly></td>
                                        </div>
                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Nombre:</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getNombre(); ?>" name="petName" value="<?php echo $pet->getNombre(); ?>" readonly></td>
                                        </div>
                                    
                                        <div class = "d-inline-flex">
                                        <button type="submit" class=" mx-2 mt-2 btn btn-danger btn-sm ">Aceptar</button>
                                             
                                    </form>
                                    
                                    <form action="<?php echo FRONT_ROOT . "Reserva/rechazarReserva" ?>" method="post">
                                        <input type="hidden" value = "<?php echo  $owner->getNombreUser(); ?>" name = "owner">
                                        <input type="hidden" value = "<?php echo $pet->getNombre(); ?>" name = "pet">
                                        <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="hidden" placeholder="<?php echo $pet->getNombre(); ?>" name="petName" value="<?php echo $pet->getNombre(); ?>" readonly></td>
                                        <span><button type="submit " class=" mt-2 btn btn-danger btn-sm ">Rechazar</button></span>
                                        </div>
                                    </form>
                                            
                                    </div>
                                </div>
                            </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

    <div class="accordion mt-5" id="accordion2">
        <div class="accordion-item mt-5">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed bg bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Pendientes de cobro
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordion2">
                <div class="accordion-body  ">            
                    <?php foreach ($listaAceptadas as $reserva) {
                            $pet = $reserva->getPet();  ?>
                        <div class="d-inline-flex flex-wrap ">
                            <div class="card m-2" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="border-bottom">En proceso de cobro.</h5>
                                        <div class="col-auto mt-2">
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($reserva->getDias() as $dias ) { ?>
                                                <li class="list-group-item"><input style=" text-align: center; font-weight:bold; color:black; border :0;" class="border-bottom" type="text" placeholder="<?php echo $dias?>" name="desde" value="" readonly></td></li>
                                                <?php }?>
                                            </ul>
                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Raza</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getRaza(); ?>" name="raza" value="<?php echo $pet->getRaza(); ?>" readonly></td>
                                        </div>
                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Tamaño:</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getTamano(); ?>" name="tamano" value="<?php echo $pet->getTamano(); ?>" readonly></td>
                                        </div>
                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Nombre:</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getNombre(); ?>" name="petName" value="<?php echo $pet->getNombre(); ?>" readonly></td>
                                        </div>
                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Valor:</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:green; border:0; " class="border-bottom" type="text" placeholder= "<?php echo '$'.$reserva->getImporteReserva(); ?>" name="petName" value="<?php echo $reserva->getImporteReserva(); ?>" readonly></td>
                                        </div>
                                </div>
                            </div>
                        </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    <div class="accordion mt-5" id="accordion3">
            <div class="accordion-item mt-5">
                <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed bg bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        Estadias en curso.
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse show" aria-labelledby="heading3" data-bs-parent="#accordion3">
                    <div class="accordion-body  ">            
                        <?php foreach ($listaConfirmadas as $reserva) {
                                $pet = $reserva->getPet();  ?>
                            <div class="d-inline-flex flex-wrap ">
                                <div class="card m-2" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="border-bottom">Estadia en curso.</h5>
                                        <form action="<?php echo FRONT_ROOT . "Keeper/rechazarReserva" ?>">
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($reserva->getDias() as $dias ) { ?>
                                                <li class="list-group-item"><input style=" text-align: center; font-weight:bold; color:black; border :0;" class="border-bottom" type="text" placeholder="<?php echo $dias?>" name="desde" value="" readonly></td></li>
                                                <?php }?>
                                            </ul>

                                            <div class="col-auto">
                                                <label for="" class="mx-2 ">
                                                    <h7>Raza</h7>
                                                </label>
                                                <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getRaza(); ?>" name="raza" value="<?php echo $pet->getRaza(); ?>" readonly></td>
                                            </div>
                                            <div class="col-auto">
                                                <label for="" class="mx-2 ">
                                                    <h7>Tamaño:</h7>
                                                </label>
                                                <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getTamano(); ?>" name="tamano" value="<?php echo $pet->getTamano(); ?>" readonly></td>
                                            </div>
                                            <div class="col-auto">
                                                <label for="" class="mx-2 ">
                                                    <h7>Nombre:</h7>
                                                </label>
                                                <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $pet->getNombre(); ?>" name="petName" value="<?php echo $pet->getNombre(); ?>" readonly></td>
                                            </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
