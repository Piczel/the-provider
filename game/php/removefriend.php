<?php
    $input = json_decode(file_get_contents("../json/removefriend-request.json"), true);   
    try{
        include "../../utility/utility.php";
        
        $connection = new DBConnection();

        $playerID = $input["playerID"];
        $forFriendID = $input["forFriendID"];

        $sql = "SELECT * FROM friendship WHERE forPlayerID = ? AND forFriendID = ?";
        $result = $connection->query($sql,[$playerID,$forFriendID]);
        if(count($result) != 1){
            throw new Exception("Ni är inte vänner");
        }

        $sql = "DELETE FROM friendship WHERE forPlayerID = ? AND forFriendID = ?";
        if($connection->execute($sql, [$playerID,$forFriendID]) === false){
            throw new Exception("Kunde inte ta bort vän");
        }

        $response = [
            "status"=>true,
            "message"=>"vän borttagen"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>