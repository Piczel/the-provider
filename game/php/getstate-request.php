<?php
    $input = json_decode(file_get_contents("../json/getglobalscore-request.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $globalscore = $input["globalscore"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$globalscore]) === false){
            throw new Exception("Kunde inte hämta globalscore");
        }


        $response = [
            "status"=>true,
            "message"=>"globalscore hämatades"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>      