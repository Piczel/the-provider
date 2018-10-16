<?php

    include 'php/verify-token.php';
    include 'php/database.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/get-day.json"), true);

        if(!verifyToken($input["adminID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }

        $connection = getConnection();
        $result = $connection->query("SELECT * FROM aktivitet");

        $activities = [];
        while($row = $result->fetch_assoc())
        {
            $activities[] = $row;
        }

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