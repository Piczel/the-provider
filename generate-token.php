<?php

    $input = json_decode(file_get_contents("json/request/generate-token.json"),TRUE);
include "php/database.php";
    $connection = new db();

    $SQL = "SELECT adminID FROM admin WHERE username = 'Casper' and password = 'Jesus'";
    
    $token = bin2hex(random_bytes(10));
    $SQL="update admin set token ='$token' where admin.adminId = 1";
            $connection->execute($SQL);

    echo json_encode([
        "status"=>true, "message"=>"Token genererad", "token"=>$token
    ]);

?>