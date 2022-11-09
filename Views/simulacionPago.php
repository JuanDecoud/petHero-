<?php

use DAO\OwnerDao;
use Models\Tarjeta;



    $owner = $_SESSION['loggedUser'];
    $tarjeta= null ;
    $ownerdao = new OwnerDao();
    $tarjeta = $ownerdao->buscarTarjeta($owner->getNombreUser());

    $reserva = $_SESSION['reserva'];
    $keeper = $reserva->getKeeper();
    $pet = $reserva->getPet();

?>


<div class = "container abs-center     ">
    <form class = "m-2 col-10 shadow  bg-body rounded" method = "post" action = "<?php echo FRONT_ROOT."Owner/principalOwner" ; ?>"> 
        <div class="form-group  mx-4">
            <h2 class = "mb-4 border-bottom col-4">Pago Estadia</h2>
            <label for="exampleInputEmail1" class = " ">Keeper</label>
            <input type="text" class="form-control  " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $keeper->getNombreUser();  ?>" name = "nombre" required readonly>
        </div>
        <div class="form-group mx-4 ">
            <label for="exampleInputEmail1" class = " ">Mascota</label>
            <input type="number" class="form-control " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $pet->getNombre(); ?>" value = "" name = "Importe" required readonly>
        </div>
        <div class="form-group mx-4  ">
            <label for="exampleInputEmail1" class = " ">Desde</label>
            <input type="text" class="form-control  " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $reserva->getFechadesde(); ?>" name = "Desde" required readonly>
        </div>
        <div class="form-group mx-4  ">
            <label for="exampleInputEmail1" class = " ">Hasta</label>
            <input type="number" class="form-control " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $reserva->getFechahasta(); ?>" value = "" name = "Hasta" required readonly>
        </div>
        <div class="form-group mx-4 ">
            <label for="exampleInputEmail1" class = " ">Importe</label>
            <input type="number" class="form-control " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $reserva->getImporteReserva(); ?>" value = "<?php echo $reserva->getImporteReserva(); ?>" name = "Importe" required readonly>
        </div>
        <div class="form-group mx-4  ">
            <label for="exampleInputEmail1" class = " ">Seleccione Tarjeta</label>
            <select name="tipo" class = "form-control " id="">
                <option value=""><?php echo $tarjeta->getNumero(); ?></option>
            </select>
        </div>
        <div class = "form-group m-4 mx-4">
            <button type="submit" class="btn btn-danger">Confirmar</button>
        </div>  
    </form>
</div>




