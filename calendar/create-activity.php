<?php

include '../utility/utility.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/create_activity.json"), true);

        if(!verifyToken($input["adminID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }

        $connection = getConnection();
        $result = $connection->query("INSERT INTO activity (name, location, description, repetition, starttime, endtime) VALUES ('Cardinal', 'Pinegrove', 'Musik', '1', '2000-10-10 12:24', '2100-12-12 12:12')");

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