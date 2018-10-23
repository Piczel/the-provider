<?php
    $input = json_decode(file_get_contents("../json/getlocalscore-request.json"), true);
    var_dump($input);
    try{

        include "../utility/utility.php";
        $connection = new DBConnection();

        $forPlayerID = $input["forPlayerID"];

        $sql = " SELECT score, `date`, game.`name` AS 'game', player.name AS 'player' FROM score INNER JOIN player ON forPlayerID = playerID INNER JOIN game ON forGameID = gameID Where forPlayerID = ? order by score DESC";

        if($connection->execute($localhighscore = $connection->query($sql,[$forPlayerID])) === false){
            throw new Exception("Kunde inte hämta poäng");
        }
        
        
        $response = [
            "status"=>true,
            "message"=>"poäng hämtat"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>