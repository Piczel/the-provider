<?php
    $input = json_decode(file_get_contents("../json/getlocalscore-request.json"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $PlayerID = $input["PlayerID"];
        $forGameID = $input["forGameID"];

        $sql = "SELECT * FROM admin_game WHERE activated_tp = 1 AND activated_user = 1 AND forGameID = ?";
        $result = $connection->query($sql,[$forGameID]);
        if(count($result) != 1){
            throw new Exception("spelet är inte aktiverat");
        }

        $sql = " SELECT score, `date`, game.`name` AS 'game', player.name AS 'player' FROM score INNER JOIN player ON forPlayerID = playerID INNER JOIN game ON forGameID = gameID Where forPlayerID = ? order by score DESC";
        $result = $connection->query($sql,[$PlayerID]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"poäng hämtat",
                "score"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hämta poäng");
        } 

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>