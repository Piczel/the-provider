<?php

include '../utility/utility.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("json/request/remove-activity.json"), true);

         if(!Token::verify($input["adminID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }
     
        $connection = new DBConnection();
        $activity = $connection ->query("SELECT * FROM activity as a INNER JOIN calendar on a.forCalendarID = calendarID INNER JOIN admin_calendar on admin_calendar.forCalendarID = calendarID INNER JOIN account on admin_calendar.forAccountID = accountID WHERE activityID=? and accountID=? ", [$input["activityID"], $input["adminID"]]);
        if (count($activity)<1)
        {
            throw new Exception("den här är fan inte din, sluta DIREKT");
        }
        if (!$connection->execute("DELETE FROM activity where activityID=?",[$input["activityID"]]))
        {
            throw new Exception("Aktiviteten kunde inte tas bort");
    
        }
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