<?php
 
include '../../utility/utility.php';

    $response = null;
    try
    {
        $input = json_decode(file_get_contents("php://input"), true);
        
        Input::validate($input, [
            'accountID' => null,
            'token' => 20,
            'activity' => null
        ]);
        
        Input::validate($input['activity'], [
            'activityID' => null,
            'name' => 80,
            'location' => 100,
            'description' => 1000,
            'starttime' => null,
            'endtime' => null
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

        if(!$connection->execute(
            'UPDATE activity SET 
                `name` = ?,
                `description` = ?,
                `location` = ?,
                starttime = ?,
                endtime = ?
            WHERE activityID = ?',
            [
                $input['activity']['name'],
                $input['activity']['description'],
                $input['activity']['location'],
                $input['activity']['starttime'],
                $input['activity']['endtime'],
                $input['activity']['activityID'],
            ]
        )) {
            throw new Exception('Kunde inte uppdatera aktiviteten');
        }
        
        $response = [
            "status" => true,
            "message" => "Aktivitet redigerad",
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