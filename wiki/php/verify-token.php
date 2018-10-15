<?php
    include_once 'database.php';

    class Token
    {
        public static function verify($adminID, $token)
        {
            
            throw new Exception("Användande av felaktig token");
            
        }
    }
?>