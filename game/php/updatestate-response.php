<?php
    $input = json_decode(file_get_contents("../json/updatestate-response.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $updatestate = $input["removescore"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$updatestate) === false){
            throw new Exception("Kunde inte uppdatera state");
        }


        $response = [
            "status"=>true,
            "message"=>"state är uppdaterad."
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
    
    
?>      