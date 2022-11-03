<?php require_once ("nav.php") ?>

  <div class = "container abs-center    col-md-4 shadow p-3 mb-5 bg-body rounded ">
    <div class = " container   ">
        <h2 class = "mb-4">Login</h2>
        <form class = "m-2" method = "post" action="<?php echo FRONT_ROOT."Home/login"; ?>"> 
                <div class="form-group m-4  ">
                    <label for="exampleInputEmail1" class = " ">Nombre Usuario</label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Usuario" name = "userName" required>
                </div>
                <div class="form-group m-4  ">
                    <label for="exampleInputEmail1" class = " ">Contraseña</label>
                    <input type="password" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Contraseña" name = "contrasena" requiered>
                </div>
                <div class = "form-group m-2">
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>  
        </form>
    </div>
  </div>

