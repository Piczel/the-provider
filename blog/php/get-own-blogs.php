<?php
    include "../database/database.php";
    include "../database/utility.php";
    Input::validate($input,[
        "adminID"=>null,
        "token"=>20
    ]);
    Token::verify($input["adminID"],$input["token"]);
    $connection = new DBConnection();


    $sql = "SELECT * FROM blog INNER JOIN blogger WHERE "
?>