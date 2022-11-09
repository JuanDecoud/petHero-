



<div class = "container abs-center     ">
    
        <form class = "m-2 col-10 shadow  bg-body rounded" method = "post" action = "<?php echo FRONT_ROOT."Owner/agregarTarjeta" ; ?>"> 
                
                <div class="form-group  mx-4">
             
                    <h2 class = "mb-4 border-bottom col-4">Nueva Tarjeta Debito/Credito</h2>
                    <label for="exampleInputEmail1" class = " ">Nombre</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Nombre" name = "nombre" required>
                </div>
                <div class="form-group mx-4  ">
                    <label for="exampleInputEmail1" class = " ">Apellido</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Apellido" name = "apellido" required>
                </div>
                <div class="form-group mx-4  ">
                    <label for="exampleInputEmail1" class = " ">Numero Tarjeta</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "numero" required>
                </div>
                <div class="form-group mx-4 ">
                    <label for="exampleInputEmail1" class = " ">Codigo Seguridad</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "codigo" required>
                </div>
                 <div class="form-group mx-4  ">
                    <label for="exampleInputEmail1" class = " ">Vencimiento</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "vencimiento" required>
                </div>
                <div class = "form-group m-4 mx-4">
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>  
        </form>
</div>






