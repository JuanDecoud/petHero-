
<style>
#form {
  width: 250px;
  margin: 0 auto;
  height: 50px;
}

#form p {
  text-align: center;
  font-size: 45px;
}

#form label {
  font-size: 45px;
}

input[type="radio"] {
 display: none;
}

label {
  color: grey;
  font-size: 25px;
  
}

.clasificacion {
  direction: rtl;
  unicode-bidi: bidi-override;
}

label:hover,
label:hover ~ label {
  color: orange;
}

input[type="radio"]:checked ~ label {
  color: orange;
}

.hola {
    color :black
}

</style>


<div class = "d-flex w-100 justify-content-center mt-5">
    <form action="<?php echo  FRONT_ROOT."Review/guardarReview" ?>" class = "d-flex w-100 justify-content-center" method = "post">
        <div class = "d-flex flex-column shadow p-3 mb-2 mt-5 bg-body rounded w-50 ">
            <h3>Comentario</h3>
            <div class="form-group">
                <h6>Cuidador</h6>
                <input type="textr" class="form-control" id="" placeholder="<?php echo $keeper->getNombreUser() ?>" name ="nombreKeeper" value ="<?php echo $keeper->getNombreUser() ?>"  readonly>
            </div>
            <div class="form-group">
                <h6>Mascota</h6>
                <input type="textr" class="form-control" id="" placeholder="<?php echo $pet->getNombre()?>" name ="nombreMascota" readonly value ="<?php echo $pet->getNombre(); ?>">
            </div>
            <div class="input-group mt-4">
                <span class="input-group-text bg-danger">Comentario</span>
                <textarea class="form-control" aria-label="With textarea" placeholder="Deje su comentario" name ="descripcion"></textarea>
            </div>
            <div>
                <h6 class = "mt-3">Calificacion:</h4>
            </div>
            <div class = "d-inline-flex justify-content-start w-100  ">
                <p class="clasificacion">
                    <input id="radio1" type="radio" name="puntaje" value="5"><!--
                    --><label for="radio1">★</label><!--
                    --><input id="radio2" type="radio" name="puntaje" value="4"><!--
                    --><label for="radio2">★</label><!--
                    --><input id="radio3" type="radio" name="puntaje" value="3"><!--
                    --><label for="radio3">★</label><!--
                    --><input id="radio4" type="radio" name="puntaje" value="2"><!--
                    --><label for="radio4">★</label><!--
                    --><input id="radio5" type="radio" name="puntaje" value="1"><!--
                    --><label for="radio5">★</label>
                </p>
            </div>
            <button type= "submit" class ="btn btn-danger btn-sm col-1 mt-2">Enviar</button>
        </div>
    </form>
</div>