<?php
    namespace DAO;

    use Models\Reserva as Reserva;

    interface IReservaDAO
    {
        function Add(Reserva $reserva);
        function GetAll();
        function getLista ();
    }
?>