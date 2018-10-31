<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include '../../utility/utility.php';

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

        if(count($connection->query("SELECT 1 FROM calendar_activity WHERE forCalendarID = ? AND forActivityID = ?", [$calendar[0]['forCalendarID'], $input['activityID']])) < 1)
        {
            throw new Exception('Du är inte deltagare i denna aktivitet');
        }

        if(!$connection->execute(
            'DELETE FROM calendar_activity WHERE forCalendarID = ? AND forActivityID = ?',
            [$calendar[0]['forCalendarID'], $input['activityID']]
        )) {
            throw new Exception('Kunde inte ta bort deltagare från aktiviteten');
        }
        
        $response = [
            "status"=>true,
            "message"=>"Deltagare borttagen"
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