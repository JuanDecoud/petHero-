<?php
    namespace DAO;

    use Models\Tarjeta as Tarjeta;

    interface ITarjetaDAO
    {
        function Add(Tarjeta $tarjeta);
        function GetAll();
    }
?>