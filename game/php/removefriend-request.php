<?php
    $input = json_decode(file_get_contents("../json/removefriend-request.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $removefriend = $input["removefriend"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$removefriend) === false){
            throw new Exception("Kunde inte ta bort kopisen");
        }


        $response = [
            "status"=>true,
            "message"=>"vän har tagits bort från vänlista"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>      