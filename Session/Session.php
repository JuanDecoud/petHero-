<?php

require_once "Config/Autoload.php";

    if($_POST)
    {
        $email=$_POST["email"];
        $password=$_POST["pass"];
        //Pensaba hacer un if para ver si es owner/keeper para redirigirlo a un menu o el otro pero no se como
        //Eso o hacer un session para owner y otro para keeper
        if($_POST)
        {
            $email=$_POST["email"];
            $password=$_POST["pass"];

            if($email== "admin@utn.com" && md5($password)=="123456"){
                session_start();
                $_SESSION["email"] = $email;
                header("location:menu-owner.php");
            } 
            else{
                header("location:index.php");
            }
        }
        //Lo dejo asi de momento para poder seguir
    }
?>