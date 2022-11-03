

<div class = "container abs-center    col-md-6 border border-dark  ">
    <div class = " container   ">
        <h2 class = "mb-4">Seleccione tipo de cuenta</h2>
        <form class = "m-2" method ="post" action = "<?php echo FRONT_ROOT."Home/seleccinarCuenta"  ?>"> 
            <div class="form-group m-2 ">
                <label for="exampleInputEmail1" class = " ">Tipo de Usuario</label>
                <select name="tipo" class = "form-control " id="">
                    <option value="Keeper">Keeper</option>
                    <option value="Owner">Owner</option>
                </select>
            </div >
            <div class = "form-group m-2">
                <button type="submit" class="btn btn-danger">Continuar</button>
            </div>  
        </form>
    </div>
</div>



