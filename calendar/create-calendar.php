<?php

    include '../utility/utility.php';

$response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/create-calendar.json"), true);
        
        if(!Token::verify($input["adminID"], $input["token"]))
        
        {
            throw new Exception("Användande av felaktig token");
        }
    
        $connection = new DBConnection();
        $calendarID = $input["calendarID"];

        $sql = "INSERT INTO calendar(calendarID) VALUES 
        
        if($connection->execute($sql,[$calendarID]) === false){
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