<?php
    $input = json_decode(file_get_contents("../json/getglobalscore.json"), true);
    var_dump($input);
    try{

        include "../database/database.php";
        $connection = new DBConnection();

        $sql = " SELECT* FROM score";
?>