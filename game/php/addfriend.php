<?php
    $input = json_decode(file_get_contents("php://input"), true);   
    try{
        include "../../utility/utility.php";
        
        $connection = new DBConnection();

        $forPlayerID = $input["forPlayerID"];
        $forFriendID = $input["forFriendID"];

        $sql = "SELECT * FROM friendship WHERE forPlayerID = ? AND forFriendID = ?";
        $result = $connection->query($sql,[$forPlayerID,$forFriendID]);
        if(count($result) == 1){
            throw new Exception("Ni är redan vänner");
        }

        $sql = "INSERT INTO friendship(forPlayerID,forFriendID) VALUES (?,?)";
        if($connection->execute($sql, [$forPlayerID,$forFriendID]) === false){
            throw new Exception("Kunde inte lägga till vän");
        }

        $sql = "INSERT INTO friendship(forFriendID,forPlayerID) VALUES (?,?)";
        if($connection->execute($sql, [$forPlayerID,$forFriendID]) === false){
            throw new Exception("Kunde inte lägga till vän");
        }
        
        $response = [
            "status"=>true,
            "message"=>"Lade till vän"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>