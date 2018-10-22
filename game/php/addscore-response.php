<?php
    $input = json_decode(file_get_contents("../json/addscore-response.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $läggatillpoäng = $input["lägga till poäng"];

        $sql = "INSERT INTO spel(lägga till poäng) VALUES (?)";
        if($connection->insert($sql, [$läggatillpoäng]) === false){
            throw new Exception("");
        }


        $response = [
            "status"=>true,
            "message"=>"poäng tilllagt"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>