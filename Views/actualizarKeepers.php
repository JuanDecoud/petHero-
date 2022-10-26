<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion2">
                            <div class = " d-inline-flex flex-wrap">
                                <?php foreach ($keeperlist as $keeper){ ?>
                                <?php foreach ($keeper->getFechas() as $estadias){?>
                            <form action="<?php echo FRONT_ROOT."Reserva/prueba" ?>" method = "post">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h7 style= "color:aqua">Disponible</h7>
                                        <h5 class="card-title"><?php echo $keeper->getNombre()." ".$keeper->getApellido(); ?></h5>
                                        <input id="prodId" name="prodId" type="hidden" value="<?php echo $keeper->getNombreUser(); ?>">
                                    </div>
                                    <div class="card-body">
                                        <div class = "col-auto">
                                            <label for="" class = "mx-2  mt-2"><h5>Desde:</h5></label>
                                            <input style =" text-align: center; font-weight:bold; color:black; border :0;" class ="border-bottom mt-1" type="text" placeholder="<?php echo $estadias->getDesde(); ?>" name ="desde"  value = "<?php echo $estadias->getDesde() ?>"readonly ></td>
                                        </div>
                                        <div class = "col-auto" >
                                            <label for="" class = "mx-2 mt-2"><h5>Hasta:</h5></label>
                                            <input style =" text-align: center; font-weight:bold; color:black; border:0;" class ="border-bottom mt-1" type="text" placeholder="<?php echo $estadias->getHasta() ?>" name ="hasta"  value = "<?php echo $estadias->getHasta() ;?>"readonly ></td>
                                        </div>
                                        <?php 
                                            $select = '<select name="tipo" class = "form-select mt-2 " id="">';
                                            $select.='<option selected >Elija su mascota</option> ';
                                            foreach ($petlist as $pet) {
                                                $select.='<option value="'.$pet->getNombre().'">'.$pet->getNombre().'</option>';
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
    