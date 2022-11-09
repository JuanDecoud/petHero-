<<<<<<< HEAD
<?php

use DAO\TipocuentaDAO;

 require_once("Header.php");
    $tipocuenta = new TipocuentaDAO ();
    $lista = array ();
    try {
        $lista = $tipocuenta->getAll();
    }
    catch (Exception $Ex){
        throw "ha ocurrido algun error";
    }
    
?>
=======

>>>>>>> 5692f2913d424f96b83856dbe5527bf05029b589

<div class = "container abs-center    col-md-6 border border-dark  ">
    <div class = " container   ">
        <h2 class = "mb-4">Seleccione tipo de cuenta</h2>
        <form class = "m-2" method ="post" action = "<?php echo FRONT_ROOT."Home/seleccinarCuenta"  ?>"> 
            <div class="form-group m-2 ">
            
                <label for="exampleInputEmail1" class = " ">Tipo de Usuario</label>
                <select name="tipo" class = "form-control " id="">
                <?php foreach ($lista as $clave => $value){ ?>    
                    <option value=<?php $value ?>><?php echo $value?></option>
                <?php }?>
                </select>
            </div >
            
            <div class = "form-group m-2">
                <button type="submit" class="btn btn-danger">Continuar</button>
            </div>  
        </form>
    </div>
</div>



