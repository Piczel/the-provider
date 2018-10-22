<?php

include '../utility/utility.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/create-activity.json"), true);

        if(!Token::verify($input["adminID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }

        $connection = new DBConnection();
        $result = $connection->query("INSERT INTO activity (name, location, description, repetition, startTime, endTime, forCalendarID ) VALUES ('Cardinal', 'Pinegrove', 'Musik', '1', '2000-10-10 12:24', '2100-12-12 12:12')");

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