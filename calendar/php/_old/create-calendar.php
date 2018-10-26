<?php

    include '../../utility/utility.php';

$response = null;
    try
    { 
        $input = json_decode(file_get_contents("php://input"), true);
        if(!verifyToken($input["adminID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }
        $connection = getConnection();
    
        $tpid = $input["tpid"];

        $sql = "INSERT INTO calendar(tpid) VALUES (?)";
        if($connection->execute($sql,[$tpid]) === false){
            throw new Exception("kunde inte skapa kalender");
        }

        $response = [
            "status"=>true,
            "message"=>"Kalender skapad"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>