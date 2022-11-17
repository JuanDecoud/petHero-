
<div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordion2">
                            <div class = " d-inline-flex flex-wrap">
                                <?php foreach ($keeperlist as $keeper){ ?>
                                <?php foreach ($keeper->getFechas() as $estadias){?>
                            <form action="<?php echo FRONT_ROOT."Reserva/seleccionarDias" ?>" method = "post">
                                <div class="card m-2" style="width: 18rem;">
                                    <div class="card-body">
                                        <h6 style= "color:aqua">Disponible</h6>
                                        <h5 class="card-title"><?php echo $keeper->getNombre()." ".$keeper->getApellido(); ?></h5>
                                        <input id="prodId" name="prodId" type="hidden" value="<?php echo $keeper->getNombreUser(); ?>">
                                        <ul class="list-group list-group-flush ">
                                            <h6 class = " mt-2 border-top">Tipos de mascota</h6>
                                            <?php foreach ($keeper->getTipo() as $tipoMascota ) { ?>
                                            <li class="list-group-item border-button"><strong><?php echo $tipoMascota ;?></strong></li>
                                            <input id="prodId" name="tipomascota[]" type="hidden" value="<?php echo $tipoMascota ;?>">
                                            <?php }?>
                                        </ul>
                                        <ul class="list-group list-group-flush ">
                                            <h6 class = " mt-2 ">Importe</h6>
                                            <li class="list-group-item border-bottom"><strong>$<?php echo $keeper->getRemuneracion();?></strong></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class = "d-inline-flex">
                                            <label for="" class = ""><h6>Desde:</h6></label>
                                            <input style =" text-align: center; font-weight:bold; color:black; border :0;" class ="border-bottom" type="text" placeholder="<?php echo $estadias->getDesde(); ?>" name ="desde"  value = "<?php echo $estadias->getDesde() ?>"readonly >
                                        </div>
                                        <div class = "d-inline-flex" >
                                            <label for="" class = ""><h6>Hasta:</h6></label>
                                            <input style =" text-align: center; font-weight:bold; color:black; border:0;" class ="border-bottom " type="text" placeholder="<?php echo $estadias->getHasta() ?>" name ="hasta"  value = "<?php echo $estadias->getHasta() ;?>"readonly >
                                        </div>
                                        <?php 
                                            $select = '<select name="tipo" class = "form-select mt-2 " id="" required>';
                                            $select.='<option value ="">Elija su mascota</option> ';
                                            foreach ($petlist as $pet) {
                                                $select.='<option required value="'.$pet->getNombre().'">'.$pet->getNombre().'</option>';
                                            }
                                            $select.='</select>';
                                            echo $select;
                                        ?>
                                        <button type="submit" class=" mt-2 btn btn-danger btn-sm ">Reservar</button>
                                    </div>
                                </div>
                            </form>
                            <?php  } }?>
                            </div>     
                        </div>
                    </div>
                    </div>
                </div>
        </div>
</div>
    