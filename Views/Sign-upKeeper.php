<?php include_once("Header.php") ;?>

<div class = "container abs-center    col-md-6 shadow p-3 mb-5 bg-body rounded ">
    <div class = " container   ">
        <h2 class = "mb-4">Registro de Usuario</h2>
        <form class = "m-2" method = "post" action = "<?php echo FRONT_ROOT."Register/agregarKeeper" ; ?>"> 
                <div class="form-group m-1  ">
                    <label for="exampleInputEmail1" class = " ">Nombre</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Nombre" name = "nombre" required>
                </div>
                <div class="form-group m-1  ">
                    <label for="exampleInputEmail1" class = " ">Apellido</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Apellido" name = "apellido" required>
                </div>
                <div class="form-group m-1  ">
                    <label for="exampleInputEmail1" class = " ">DNI</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="DNI" name = "DNI" required>
                </div>
                <div class="form-group m-1 ">
                    <label for="exampleInputEmail1" class = " ">Telefono</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Telefono" name = "telefono" required>
                </div>
                 <div class="form-group m-1  ">
                    <label for="exampleInputEmail1" class = " ">Nombre Usuario</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Usuario" name = "userName" required>
                </div>
                <div class="form-group m-1  ">
                    <label for="exampleInputEmail1" class = " ">Contraseña</label>
                    <input type="password" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Contraseña" name = "contrasena" required>
                </div>
                <div class="form-group m-1  ">
                    <label for="exampleInputEmail1" class = " ">Remuneracion Solicitada</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Remuneracion Deseada" name = "remuneracion" required>
                </div>
                <h6 class = "m-1"> Tipos de Mascota</h6>
                <div class="form-check form-check-inline m-1">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Chica" name = "mascota1">
                    <label class="form-check-label" for="inlineCheckbox1"  value = "Chica">Chica</label>
                </div>
                <div class="form-check form-check-inline m-1">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Mediana" name = "mascota2">
                    <label class="form-check-label" for="inlineCheckbox1"  value = "Chica">Mediana</label>
                </div>
                <div class="form-check form-check-inline m-1">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Grande" name = "mascota3">
                    <label class="form-check-label" for="inlineCheckbox1"  value = "Chica">Grande</label>
                </div>
                <div class = "form-group m-2">
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>  
        </form>
    </div>
</div>

<?php include_once("Footer.php"); ?>