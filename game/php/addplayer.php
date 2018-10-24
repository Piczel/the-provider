<?php
    $input = json_decode(file_get_contents("../json/addplayer-request.json"), true);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $spelarensnamn = $input["username"];

        $sql = "INSERT INTO player(`name`) VALUES (?)";
        if($connection->execute($sql, [$spelarensnamn]) === false){
            throw new Exception("Kunde inte lägga till spelare");
        }
        
        $response = [
            "status"=>true,
            "message"=>"Spelare tillagd"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>

