<?php
    $input = json_decode(file_get_contents("../json/addfriend-request.json"), true);
  
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();
        
        
        $forPlayerID = $input["forPlayerID"];
        $forFriendID = $input["forFriendID"];
        $sql = "INSERT INTO friendship(forPlayerID,forFriendID) VALUES (?,?)";
        if($connection->execute($sql, [$forFriendID,$forPlayerID]) === false){
            throw new Exception("Kunde inte lägga till vän");
        }


        $response = [
            "status"=>true,
            "message"=>"spelare tillagd som vän"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>