<?php

use Models\Keeper;

require_once("Header.php");
require_once("navKeeper.php");

use DAO\KeeperDAO as KeeperDAO;
use DAO\ReservaDAO;
use Models\Pet;

$keepDao = new KeeperDao();
$userLogged = $_SESSION['loggedUser'];
$user = $keepDao->obtenerUser($userLogged->getNombreUser());
$fechas = $user->getFechas();

$reservadao = new ReservaDAO();
$listaReservas = $reservadao->buscarReservas($user);


?>

<div class="container mt-5   shadow p-3 mb-5 bg-ligh rounded">
    <div class="d-flex  flex-row  justify-content-around">
        <form action="<?php echo FRONT_ROOT . "Keeper/asignarFecha"; ?>" method="post" class="form-group mr-auto p-2 shadow p-3 mb-5 bg-ligh rounded ">
            <h4 class="my-2">Agregar Disponibilidad</h4>
            <div class="col-auto mx-auto">
                <label for="" class="mx-2">
                    <h5>Desde:</h5>
                </label>
                <input class="calendar my-4 col-8" style="border 2px solid" type="date" name="desde" placeholder="" required>
            </div>

            <div class="col-auto mx-auto">
                <label for="" class="mx-2">
                    <h5>Hasta:</h5>
                </label>
                <input class="calendar my-4 col-8" style="border 2px solid" type="date" name="hasta" placeholder="" required>
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
</div>


<div class="container mt-5  shadow p-3 mb-5 bg-ligh rounded col col-10">
    <div class="accordion mt-5" id="accordionExample">
        <div class="accordion-item mt-5">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed bg bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Estadias Solicitadas
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">

                    <div class="d-inline-flex flew-wrap">
                        <?php foreach ($listaReservas as $reserva) {
                            $pet = $reserva->getPet();  ?>
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="border-bottom">Solicitud de estadia.</h5>
                                    <form action="">
                                        <div class="col-auto mt-2">
                                            <label for="" class="mx-2  ">
                                                <h7>Desde:</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border :0;" class="border-bottom" type="text" placeholder="<?php echo $reserva->getFechadesde(); ?>" name="desde" value="<?php echo $reserva->getFechadesde(); ?>" readonly></td>
                                        </div>

                                        <div class="col-auto">
                                            <label for="" class="mx-2 ">
                                                <h7>Hasta:</h7>
                                            </label>
                                            <input style=" text-align: center; font-weight:bold; color:black; border:0;" class="border-bottom" type="text" placeholder="<?php echo $reserva->getFechahasta(); ?>" name="hasta" value="<?php echo $reserva->getFechahasta(); ?>" readonly></td>
                                        </div>

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
                                        <div class="d-inline-flex ">
                                            <button type="submit" class=" mx-2 mt-2 btn btn-danger btn-sm ">Aceptar</button>
                                    </form>
                                    <form action="" method="post">
                                        <button type="submit " class=" mt-2 btn btn-danger btn-sm ">Rechazar</button>
                                    </form>
                                </div>
                            <?php } ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <?php require_once("Footer.php"); ?>