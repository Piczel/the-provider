<?php

    $input = json_decode(file_get_contents("json/request/generate-token.json"),TRUE);
include "php/database.php";
    $connection = new db();

?>