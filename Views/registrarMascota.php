<?php   
    require_once ("Header.php");
?>

<div class = "container col-md-6 mt-5     shadow p-3 mb-5 bg-body rounded">
    <div class = " container  ">
        <h2 class = "m-0">Registro de Mascota</h2>
        <form class = "m-2" method = "post" action = "<?php echo FRONT_ROOT."Pet/agregarMascota" ?>" enctype="multipart/form-data"> 
               <div class="form-group   ">
                    <label for="exampleInputEmail1" class = " mb-2"><strong>Nombre</strong></label>
                    <input type="text" class="form-control  " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "nombre" require>
                </div>
                <div class="form-group  ">
                    <label for="exampleInputEmail1" class = "mb-2" ><strong>Raza</strong></label>
                    <input type="text" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "raza" requiere>
                </div>
                <div class="form-group ">
                    <label for="exampleInputEmail1" class = "mb-2" ><strong>Tamaño</strong></label>
                    <input type="text" class="form-control " id="exampleInputEmail1" 
                        aria-describedby="emailHelp" placeholder="" name = "tamaño" requiere>
                </div>
                <div class="mb-3 ">
                    <label for="formFile" class="form-label"><strong>Foto</strong></label>
                    <input class="form-control" type="file" id="formFile" name ="imagenPerfil" >
                </div>
                <div class="mb-3 ">
                    <label for="formFile" class="form-label"><strong>Plan Vacunacion</strong></label>
                    <input class="form-control " type="file" id="formFile" name = "vacunacion" >
                </div>
                <div class="mb-3 ">
                    <label for="formFile" class="form-label"><strong>Video</strong></label>
                    <input class="form-control " type="file" id="formFile" name = "video" >
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label"><strong>Observacion</strong></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name = "observacion"></textarea>
                </div>
                <div class = "form-group m-0">
                    <button type="submit" class="btn btn-danger">Agregar</button>
                </div>
        </form>
    </div>
</div>


<?php   
    require_once ("Footer.php");
?>