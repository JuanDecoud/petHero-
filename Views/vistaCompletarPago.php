

<div class = "container abs-center     ">
    <form class = "m-2 col-10 shadow  bg-body rounded" method = "post" action = "<?php echo FRONT_ROOT."Review/vistaReview" ; ?>"> 
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
        <h6>Estadia :</h6>
        <?php foreach ($reserva->getDias() as $dias ) { ?>
        <input style=" text-align: center; font-weight:bold; color:black; border :0;" class="border-bottom" type="text" placeholder="<?php echo $dias?>" name="arreglo[]" value="<?php echo $dias?>" readonly>
        <?php }?>

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

