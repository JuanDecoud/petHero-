
<div class = "d-flex  flex-column shadow p-3 mb-5 bg-ligh rounded abs-center w-50 mx-auto">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Pet</th>
                <th scope="col">Fecha finalizacion</th>
                <th scope="col">Importe Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaEstadias as $estadias){
                $pet = $estadias->getPet();
                $arregloFechas =$estadias->getDias();
                asort($arregloFechas);
                $fechafinalizacion=array_pop($arregloFechas);
            ?>
            <tr>
                <td><?php echo $pet->getNombre() ?></td>
                <td><?php echo $fechafinalizacion ?></td>
                <td><?php echo $estadias->getImporteTotal() ?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
    <form action="<?php echo FRONT_ROOT."Reserva/vistaKeeper"; ?>" method ="get">
        <div class = "d-inline-flex justify-content-start">
            <button type="submit" class="btn btn-danger btn-md ">Atras</button>
        </div>
    </form>    
</div>
