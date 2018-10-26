<?php

    include '../../utility/utility.php';


    $response = null;
    try
    {
        $input = json_decode(file_get_contents("php://input"), true);
        
        Input::validate($input, [
            'accountID' => null,
            'token' => 20
        ]);

        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }
        $date = $input['date'] ?? date('Y-m-d');

        $date_from = $date . ' 0:00';
        $date_to = $date . ' 23:59';

        $connection = new DBConnection();

        $calendar = $connection->query('SELECT forCalendarID FROM admin_calendar WHERE activated_tp = 1 AND forAccountID = ?', [$input['accountID']]);
        if(count($calendar) < 1)
        {
            throw new Exception('Du har ingen aktiverad kalender');
        }

        $result = $connection->query(
            "SELECT
                activityID,
                `name`,
                `description`,
                `location`,
                starttime,
                endtime
            FROM account AS a
                INNER JOIN admin_calendar AS ac
                    ON ac.forAccountID = a.accountID
                INNER JOIN calendar AS c
                    ON c.calendarID = ac.forCalendarID
                LEFT JOIN calendar_activity AS ca
                    ON ca.forCalendarID = c.calendarID
                INNER JOIN activity
                    ON activity.forCalendarID = c.calendarID 
                        OR ca.forActivityID = activity.activityID

            WHERE (
                starttime <= ? AND endtime >= ?
            ) AND accountID = ?",
            [$date_to, $date_from, $input['accountID']]
        );

        $activities = $result;
        
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