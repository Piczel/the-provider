<?php
    $input = json_decode(file_get_contents("../json/removedeveloper-request.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $removedeveloper = $input["removedeveloper"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$removedeveloper) === false){
            throw new Exception("Kunde inte ta utvecklare");
        }


        $response = [
            "status"=>true,
            "message"=>"utvecklare har tagits."
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>      