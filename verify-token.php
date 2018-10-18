<?PHP
    function verify_token($adminID, $token){
        include "php/database.php";
        $connection = new db();
        $admin = $connection->execute("SELECT adminID, token, tokenTime FROM `admin` WHERE adminID = $adminID");

        if($admin->num_rows != 1){
            return false;
        }

        $admin = $admin->fetch_assoc();

        if($admin["token"]!==$token){
            return false;
        }

        
        if(dateDifference(date("Y-m-d H:i:s"),$admin["tokenTime"]) < 30){

            return true;
        }
        
        return false;
    }
    var_dump(verify_token(1,"89a055e19402af027f21"));


    function dateDifference($date_1 , $date_2)
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        
        $interval = date_diff($datetime1, $datetime2);

        $minutes = 0;
        $minutes += ((int)$interval->format("%y") * 525948.766);
        $minutes += ((int)$interval->format("%m") * 43829);
        $minutes += ((int)$interval->format("%d") * 1440);
        $minutes += ((int)$interval->format("%h") * 60);
        $minutes += ((int)$interval->format("%i"));

        return $minutes;
        
        
    }
?>