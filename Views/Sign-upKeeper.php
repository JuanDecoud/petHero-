<?php include_once("Header.php") ?>

<div class = "container abs-center    col-md-6 bg-light  ">
    <div class = " container   ">
        <h2 class = "mb-4">Registro de Usuario</h2>
        <form class = "m-2" method = "post" action = "<?php echo FRONT_ROOT."Register/agregar"  ?>"> 
                <div class="form-group m-4  ">
                    <label for="exampleInputEmail1" class = " ">Nombre Usuario</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Usuario" name = "userName" require>
                </div>
                <div class="form-group m-4  ">
                    <label for="exampleInputEmail1" class = " ">Contraseña</label>
                    <input type="password" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Contraseña" name = "contrasena" requiere>
                </div>
                <div class="form-group m-4  ">
                    <label for="exampleInputEmail1" class = " ">Remuneracion Solicitada</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Remuneracion Deseada" name = "remuneracion" requiere>
                </div>
                <h6 class = "m-4"> Tipos de Mascota</h6>
                <div class="form-check form-check-inline m-4">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Chica" name = "mascota1">
                    <label class="form-check-label" for="inlineCheckbox1"  value = "Chica">Chica</label>
                </div>
                <div class="form-check form-check-inline m-4">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Mediana" name = "mascota2">
                    <label class="form-check-label" for="inlineCheckbox1"  value = "Chica">Mediana</label>
                </div>
                <div class="form-check form-check-inline m-4">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Grande" name = "mascota3">
                    <label class="form-check-label" for="inlineCheckbox1"  value = "Chica">Grande</label>
                </div>
                <div class = "form-group m-2">
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>  
        </form>
    </div>
</div>

<?php include_once("Footer.php") ?>