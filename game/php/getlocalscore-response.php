<?php
    $input = json_decode(file_get_contents("../json/getlocalscore-response.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $localscore = $input["globalscore"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$localscore]) === false){
            throw new Exception("Kunde inte hämta localscore");
        }


        $response = [
            "status"=>true,
            "message"=>"localscore hämatades"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>      