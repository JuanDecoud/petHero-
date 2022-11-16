
<div class = "container col-md-6 mt-5     shadow p-3 mb-5 bg-body rounded">
    
    <div class = " container  ">
        <h2 class = "m-0">Registro de Mascota  <span><img style = "ml-4" src="<?php echo FRONT_ROOT.VIEWS_PATH."img/mascota2.png";?>" alt=""></span></h2>
        <form class = "m-2" method = "post" action = "<?php echo FRONT_ROOT."Pet/agregarMascota" ?>" enctype="multipart/form-data"> 
               <div class="form-group   ">
                    <label for="exampleInputEmail1" class = " mb-2"><strong>Nombre</strong></label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "nombre" required>
                </div>
                <div class="form-group  ">
                    <label for="exampleInputEmail1" class = "mb-2" ><strong>Raza</strong></label>
                    <input type="text" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "raza" required>
                </div>
                <div class="form-group ">
                    <label for="exampleInputEmail1" class = "mb-2" ><strong>Tamaño</strong></label>
                    <select name="tamaño" class="form-select" id="iname" placeholder="Seleccione tamaño" required>
                    <option value="Chica">Chica</option>
                    <option value="Mediana">Mediana</option>
                    <option value="Grande">Grande</option>
                    </select>
                    <!-- <input type="text" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "tamaño" requiere> -->
                </div>
                <div class="mb-3 ">
                    <label for="formFile" class="form-label"><strong>Foto</strong></label>
                    <input class="form-control" type="file" id="formFile" name ="imagenPerfil" required>
                </div>
                <div class="mb-3 ">
                    <label for="formFile" class="form-label"><strong>Plan Vacunacion</strong></label>
                    <input class="form-control " type="file" id="formFile" name = "vacunacion" required >
                </div>
                <div class="mb-3 ">
                    <label for="formFile" class="form-label"><strong>Video</strong></label>
                    <input class="form-control " type="file" id="formFile" name = "video" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label"><strong>Observacion</strong></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name = "observacion" required></textarea>
                </div>
                <div class = "form-group m-0">
                    <button type="submit" class="btn btn-danger">Agregar</button>
                </div>
        </form>
    </div>
</div>