<?php

    function getConnection(
        $host = "localhost",
        $user = "root",
        $pass = "",
        $dbname = "calendar"
    ) {
        $connection = new mysqli($host, $user, $pass, $dbname);
        $connection->set_charset("utf8");
        return $connection;
    }

?>