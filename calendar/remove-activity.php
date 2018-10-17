<?php

    include 'php/verify-token.php';
    include 'php/database.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/remove_activity.json"), true);

        if(!verifyToken($input["adminID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }

        $connection = getConnection();
        $result = $connection->query("DELETE FROM activity WHERE activityID='2'");

        $response = [
            "status" => true,
            "message" => "Aktivitet raderad",
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