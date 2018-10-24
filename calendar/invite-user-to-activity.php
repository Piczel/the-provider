<?php
    $input = json_decode(file_get_contents("json/request/invite-user-to-activity.json"), true);
    try{
        include '../utility/utility.php';
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Användande av felaktig token");
        }
        $connection = new DBConnection();

        $account = $input["accountID"];
        $admin = $input["adminID"];
        $activity = $input["activityID"];
        $calendar = $input["calendarID"];
        $username = $input["username"];

        $sql = "SELECT * FROM admin_calendar WHERE activated_tp = 1 AND activated_user = 1 AND forCalendarID = ? AND forAccountID = ?";
        $result = $connection->query($sql,[$calendar,$account]);
        if(count($result) != 1){
            throw new Exception("Kalendaren är inte aktiverad");
        }

        $sql = "SELECT name FROM activity WHERE forCalendarID = ?";
        $result = $connection->query($sql,[$calendar]);
        if(count($result) != 1){
            throw new Exception("Inte med i aktiviteten");
        }

        $sql = "SELECT forCalendarID FROM admin_calendar INNER JOIN account WHERE account.accountID = admin_calendar.forAccountID AND username = ?";
        $result = $connection->query($sql,[$username]);
        if(count($result) != 1){
            throw new Exception("Kunde inte hitta konto");
        }

        $invite = $result[0]["forCalendarID"];

        $sql = "SELECT * FROM calendar_activity WHERE forActivityID = ? AND forCalendarID = ?";
        $result = $connection->query($sql,[$activity,$invite]);
        if(count($result) != 0){    
            throw new Exception("Användaren är redan delaktig");
        }
        var_dump($activity);
        var_dump($invite);
        $sql = "INSERT INTO calendar_activity(forActivityID,forCalendarID) VALUES (?,?)";
        if($connection->execute($sql,[$activity,$invite]) === false){
            throw new Exception("Kunde inte lägga till konto");
        }
         
        $response = [
            "status"=>true,
            "message"=>"Konto tillagt"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
echo json_encode($response);
?>