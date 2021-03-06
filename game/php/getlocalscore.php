<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $playerID = $input["playerID"];
        $forGameID = $input["forGameID"];

        $sql = "SELECT * FROM admin_game WHERE activated_tp = 1 AND activated_user = 1 AND forGameID = ?";
        $result = $connection->query($sql,[$forGameID]);
        if(count($result) != 1){
            throw new Exception("spelet är inte aktiverat");
        }

        $sql = "SELECT score, `date`, game.name AS 'game', player.name AS 'player' FROM score INNER JOIN player INNER JOIN game ON score.forPlayerID = player.playerID AND score.forGameID = game.gameID WHERE player.playerID = ? order by score DESC";
        $result = $connection->query($sql,[$playerID]);
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