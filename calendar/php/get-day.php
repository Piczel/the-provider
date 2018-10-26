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

        $date_from = date('Y-m-d') . ' 0:00';
        $date_to = date('Y-m-d') . ' 23:59';

        
        exit;
        $connection = new DBConnection();
        $result = $connection->query("SELECT * FROM activity WHERE startTime BETWEEN ? AND ?", [$date_from, $date_to]);

        $activities = $result;
        
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