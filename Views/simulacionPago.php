<?php require_once ("Header.php");

$owner = $_SESSION['loggedUser'];
$tarjeta = $owner->getTarjeta();

?>


<div class = "container abs-center     ">
    <form class = "m-2 col-10 shadow  bg-body rounded" method = "post" action = "<?php echo FRONT_ROOT."Owner/principalOwner" ; ?>"> 
        <div class="form-group  mx-4">
            <h2 class = "mb-4 border-bottom col-4">Pago Estadia</h2>
            <label for="exampleInputEmail1" class = " ">Keeper</label>
            <input type="text" class="form-control  " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $keeper ?>" name = "nombre" required readonly>
        </div>
        <div class="form-group mx-4  ">
            <label for="exampleInputEmail1" class = " ">Desde</label>
            <input type="text" class="form-control  " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $desde ?>" name = "Desde" required readonly>
        </div>
        <div class="form-group mx-4  ">
            <label for="exampleInputEmail1" class = " ">Hasta</label>
            <input type="number" class="form-control " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $hasta ?>" value = "<?php echo $hasta ?>" name = "Hasta" required readonly>
        </div>
        <div class="form-group mx-4 ">
            <label for="exampleInputEmail1" class = " ">Importe</label>
            <input type="number" class="form-control " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $importe ?>" value = "<?php echo $importe ?>" name = "Importe" required readonly>
        </div>
        <div class="form-group mx-4  ">
            <label for="exampleInputEmail1" class = " ">Seleccione Tarjeta</label>
            <select name="tipo" class = "form-control " id="">
                <option value=""></option>
            </select>
        </div>
        <div class = "form-group m-4 mx-4">
            <button type="submit" class="btn btn-danger">Confirmar</button>
        </div>  
    </form>
</div>






<?php  require_once("Footer.php");?>