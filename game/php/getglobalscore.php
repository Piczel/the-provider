<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $gameID = $input["gameID"];

        $sql = "SELECT * FROM admin_game WHERE activated_tp = 1 AND activated_user = 1 AND forGameID = ?";
        $result = $connection->query($sql,[$gameID]);
        if(count($result) != 1){
            throw new Exception("spelet är inte aktiverat");
        }

        $sql = "SELECT score, `date`, player.name, game.name AS 'game' FROM score INNER JOIN player ON forPlayerID = playerID INNER JOIN game ON forGameID = gameID WHERE forGameID = ? order by score DESC";
        $result = $connection->query($sql,[$gameID]);
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