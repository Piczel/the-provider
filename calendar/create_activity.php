<?php

    include 'php/verify-token.php';
    include 'php/database.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/create_activity.json"), true);

        if(!verifyToken($input["adminID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }

        $connection = getConnection();
        $result = $connection->query("INSERT INTO activity (activityID, name, location, description, repetition, starttime, endtime) VALUES ('1', 'Cardinal', 'Pinegrove', 'Musik', '1', '1', '1')");

        $response = [
            "status" => true,
            "message" => "Aktivitet skapad",
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