<?php

include '../../utility/utility.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("php://input"), true);

        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }
 
        $connection = new DBConnection();
        $result = $connection->query("SELECT * FROM activity WHERE startTime BETWEEN '?' AND '?'");

        $activities = [$result];
        
        $response = [
            "status" => true,
            "message" => "Dagen hämtad",
            "activities" => $activities
        ];
    } catch(Exception $exc)
    {
        $response = [
            "status" => false,
            "message" => $exc->getMessage()
        ];
        
    } finally
    {
        echo json_encode($response);
    }
?>