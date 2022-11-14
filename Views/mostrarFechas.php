
<form class = "mt-2 col-4 shadow p-3 mb-2 bg-body rounded mt-6 mx-auto mt-4 " method = "post" action="<?php echo FRONT_ROOT."Reserva/solicitadudEstadia"; ?>"> 
        <div class="form-group m-2  ">
            <label for="exampleInputEmail1" class = " ">Cuidador</label>
            <input type="text" class="form-control  "  placeholder="<?php echo $nombreKeeper ?>" name = "keeper" value = "<?php echo $nombreKeeper ?>" required readonly>
        </div>
        <div class="form-group m-2  ">
            <label for="exampleInputEmail1" class = " ">Mascota</label>
            <input type="text" class="form-control " id="exampleInputEmail1" 
                aria-describedby="emailHelp" placeholder="<?php echo $nombreMascota ?>" name ="mascota" required value ="<?php echo $nombreMascota?>" readonly >
        </div>
        <table class="table table-hover mt-2">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th>Seleccionar</th>
                </tr>
            </thead> 
            <tbody>
            <?php foreach ($array_fechas as $fecha) { ?>
                <tr>
                    <td scope="col"><?php echo $fecha ?></td>
                    <td scope = "col">
                        <div class="form-check form-switch">
                            <input  style = "text-align:center;"class="form-check-input " type="checkbox" id="flexSwitchCheckDefault" value = "<?php echo $fecha ?>" name = "arreglo[]">
                        </div>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <div class = "form-group mb-2">
            <button type="submit" class="btn btn-danger ">Confirmar</button>
        </div> 
</form>



