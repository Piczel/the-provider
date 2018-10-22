<?php

    include '../utility/utility.php';

$response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/create-calendar.json"), true);
        
        if(!Token::verify($input["accountID"], $input["token"]))
        
        {
            throw new Exception("Användande av felaktig token");
        }
    
        $connection = new DBConnection();
        $calendarID = $input["calendarID"];

        $result = $connection->query("INSERT INTO calendar (calendarID) VALUES ('?')");

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