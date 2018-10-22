<?php
    $input = json_decode(file_get_contents("../json/getglobalscore.json"), true);
    var_dump($input);
    try{

        include "../utility/utility.php";
        $connection = new DBConnection();

        $gameID = $input["gameID"];

        $sql = " SELECT score, `date`, `name` FROM score INNER JOIN player ON forPlayerID = playerID WHERE forGameID = ? order by score DESC";

        if($connection->execute($highscore = $connection->query($sql,[$gameID])) === false){
            throw new Exception("Kunde inte lägga till poäng");
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