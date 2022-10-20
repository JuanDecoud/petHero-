<?php require_once("Header.php") ?>

<div class = "container abs-center    col-md-6 bg-light  ">
    <div class = " container   ">
        <h2 class = "mb-4">Seleccione tipo de cuenta</h2>
        <form class = "m-2" method = "post" action = "<?php echo FRONT_ROOT."Register/registrar"  ?>"> 
            <div class="form-group m-2 ">
                <label for="exampleInputEmail1" class = " ">Tipo de Usuario</label>
                <select name="tipo" class = "form-control " id="">
                    <option value="">Keeper</option>
                    <option value="">Owner</option>
                </select>
            </div >
            <div class = "form-group m-2">
                <button type="submit" class="btn btn-success">Continuar</button>
            </div>  
        </form>
    </div>
</div>



<?php require_once("Footer.php") ?>