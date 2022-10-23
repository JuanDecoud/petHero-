<?php include_once("Header.php") ;?>

    <center>
  <form action="<?php echo FRONT_ROOT."Register/agregarOwner"; ?>" method="post">
        
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

        <label for:"iname">Usuario:</label>
        <input type="text" name="userName" id="iname" placeholder="Escriba su Nombre de Usuario"><br>
        <label for:"ipass">Contraseña:</label>
        <input type="password" name="contrasena" id="ipass" placeholder="Escriba su Contraseña"><br>
    <br>
    <button type="submit">Crear usuario</button>
  </form>
  </center>

<?php include_once("Footer.php"); ?>