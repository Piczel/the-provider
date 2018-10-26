<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include '../../utility/utility.php';

        Input::validate($input, [
            'accountID' => null,
            'token' => 20,
            'invitedAccountID' => null,
            "activityID" => null
        ]);

        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }
        
        $connection = new DBConnection();

        $calendar_own = $connection->query('SELECT forCalendarID FROM admin_calendar WHERE activated_tp = 1 AND forAccountID = ?', [$input['accountID']]);
        if(count($calendar_own) < 1)
        {
            throw new Exception('Du har ingen aktiverad kalender');
        }


        $calendar = $connection->query('SELECT forCalendarID FROM admin_calendar WHERE activated_tp = 1 AND forAccountID = ?', [$input['invitedAccountID']]);
        if(count($calendar) < 1)
        {
            throw new Exception('Det inbjudna kontot har ingen aktiverad kalender');
        }

        if(count($connection->query(
            'SELECT 1 FROM calendar_activity WHERE forActivityID = ? AND forCalendarID = ?',
            [$input['activityID'], $calendar[0]['forCalendarID']]
        ))) {
            throw new Exception('Kontot är redan deltagande i aktiviteten');
        }

        if(!$connection->execute(
            'INSERT INTO calendar_activity (forActivityID, forCalendarID) VALUES (?, ?)',
            [$input['activityID'], $calendar[0]['forCalendarID']]
        )) {
            throw new Exception('Kunde inte lägga till deltagare i aktiviteten');
        }
        
        
        $response = [
            "status"=>true,
            "message"=>"Deltagare tillagd"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    } finally
    {

        echo json_encode($response);
    }
?>