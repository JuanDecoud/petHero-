
<div class = "d-flex  flex-column shadow p-3 mb-5 bg-ligh rounded abs-center w-50 mx-auto">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Descripcion</th>
                <th scope="col">Fecha</th>
                <th scope="col">Puntuacion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listareviews as $review){ ?>
            <tr>
                <td><?php echo $review->getDescription() ?></td>
                <td><?php echo $review->getFecha() ?></td>
                <td><?php echo $review->getPuntaje() ?></td>
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
