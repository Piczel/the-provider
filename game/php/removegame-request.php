<?php
    $input = json_decode(file_get_contents("../json/removegame-request.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $removefriend = $input["removegame"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$removefriend) === false){
            throw new Exception("Kunde inte ta bort spelen.");
        }


        $response = [
            "status"=>true,
            "message"=>"spelen har tagits bort."
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);

?>      