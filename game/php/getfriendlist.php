<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $forPlayerID = $input["forPlayerID"];

        $sql = "SELECT * FROM friendship WHERE forPlayerID = ?";
        $result = $connection->query($sql,[$forPlayerID]);
        if(count($result) != 1){
            throw new Exception("Du har inga vänner");
        }

        $sql = 
            "SELECT
                forFriendID,
                `name` AS friendName
            FROM friendship
                INNER JOIN player 
                    ON forFriendID = playerID
            WHERE forPlayerID = ?";
        $result = $connection->query($sql,[$forPlayerID]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"vänlista hämtad",
                "score"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hämta vänlista");
        }

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>