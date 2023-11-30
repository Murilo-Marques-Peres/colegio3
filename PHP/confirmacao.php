<?php
    class confirmacao{
        public static function logado(){
            return isset($_SESSION["login"]) ? true : false;
        }
    }
?>