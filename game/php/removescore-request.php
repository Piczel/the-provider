<?php
    $input = json_decode(file_get_contents("../json/removescore-request.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $removefriend = $input["removescore"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$removefriend) === false){
            throw new Exception("Kunde inte ta bort poäng");
        }


        $response = [
            "status"=>true,
            "message"=>"poängen har tagits bort."
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
    
?>      