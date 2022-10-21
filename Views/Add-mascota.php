<?php include_once("Header.php") ?>

    <center>
  <form action="<?php echo FRONT_ROOT."" ?>" method="post">
        <label for:"iname">Nombre:</label>
        <input type="text" name="nombre" id="iname" placeholder="Escriba el Nombre de su Mascota"><br>
        <label for:"iowner">Owner:</label>
        <input type="text" name="owner" id="iowner" placeholder="Escriba su Nombre de Usuario"><br>
        <label for:"iraza">Raza:</label>
        <input type="text" name="raza" id="iraza" placeholder="Escriba la Raza de su Mascota"><br>
        <label for:"iname">Tamaño:</label>
        <input type="text" name="userName" id="iname" placeholder="Chica/Mediana/Grande"><br>
        <label for="iplan">Plan de Vacunacion:</label>
        <textarea name="plan" id="iplan" cols="30" rows="10" 
        placeholder="Escriba el Plan de Vacunacion de su Mascota"></textarea>
        <label for="iobs">Observaciones Generales:</label>
        <textarea name="observaciones" id="iobs" cols="30" rows="10" 
        placeholder="Escriba las Observaciones Generales si tiene alguna"></textarea>

    <br>
    <button type="submit">Agregar Mascota</button>
  </form>
  </center>

<?php include_once("Footer.php") ?>