<?php
    $input = json_decode(file_get_contents("../json/getglobalscore.json"), true);
    var_dump($input);
    try{

        include "../database/database.php";
        $connection = new DBConnection();

        //definiera gameID

        $sql = " SELECT score, `date`, `name` FROM score INNER JOIN player ON forPlayerID = playerID WHERE forGameID = ? order by score DESC";

        $highscore = $connection->query($sql,[$gameID]);
        
        
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