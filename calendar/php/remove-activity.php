<?php

include '../../utility/utility.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("php://input"), true);

        Input::validate($input, [
            'accountID' => null,
            'token' => 20,
            'activityID' => null
        ]);

        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }
     
        $connection = new DBConnection();
        
        $calendar = $connection->query('SELECT forCalendarID FROM admin_calendar WHERE activated_tp = 1 AND forAccountID = ?', [$input['accountID']]);
        if(count($calendar) < 1)
        {
            throw new Exception('Du har ingen aktiverad kalender');
        }
        

        if(!$connection->execute("DELETE FROM activity where activityID = ?",[$input["activityID"]]))
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