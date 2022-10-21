<?php require_once("Header.php") ?>

<nav class="navbar navbar-expand-lg bg-danger">
        <div class="container-fluid ">
          <a class="navbar-brand border-bottom " href="#">
            <img src="<?php echo FRONT_ROOT.VIEWS_PATH."img/caminando-con-perro.png" ?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
             Pet Hero
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse " id="navbarSupportedContent">

            <ul class="navbar-nav mx-auto ">
                <li class="nav-item  border-dark border-start  m-1">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item  border-dark border-start border-end m-1">
                    <a class="nav-link active" href="#">Estadias</a>
                </li>
            </ul>
            <ul class="navbar-nav  me-5">
                <li class="nav-item border-start border-dark">
                    <a class="nav-link active" aria-current="page" href="<?php echo FRONT_ROOT."Home/vistaLogin" ?>">Login</a>
                </li>
                <li class="nav-item border-dark border-start ">
                    <a class="nav-link active" href="<?php echo FRONT_ROOT."Home/vistaTipocuenta" ?>">Sing Up</a>
                </li>
            </ul>

            </ul>
          </div>
        </div>
</nav>

<?php require_once("Footer.php") ; ?>