


  <div class = "container abs-center     ">
        <form class = "m-2 col-10 shadow  bg-body rounded" method = "post" action = "<?php echo FRONT_ROOT."Register/agregarOwner"; ; ?>"> 
                
                <div class="form-group  mx-4">
                    <h2 class = "mb-4 border-bottom col-4">Registro de Usuario</h2>
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
                    <label for="exampleInputEmail1" class = " ">DNI</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="DNI" name = "DNI" required>
                </div>
                <div class="form-group mx-4 ">
                    <label for="exampleInputEmail1" class = " ">Telefono</label>
                    <input type="number" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Telefono" name = "telefono" required>
                </div>
                 <div class="form-group mx-4  ">
                    <label for="exampleInputEmail1" class = " ">Nombre Usuario</label>
                    <input type="email" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Usuario" name = "userName" required>
                </div>
                <div class="form-group  mx-4 ">
                    <label for="exampleInputEmail1" class = " ">Contraseña</label>
                    <input type="password" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="Contraseña" name = "contrasena" required>
                </div>
                <div class = "form-group m-4 mx-4">
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>  
        </form>
</div>

