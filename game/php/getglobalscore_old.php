<?php
    $input = json_decode(file_get_contents("../json/getglobalscore-response.json"), true);
    
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $gameID = $input["gameID"];
        

        $sql = "SELECT * FROM `score` WHERE forGameID=1 ORDER BY `score` DESC LIMIT 20";
        
        $result=$connection->query($sql,[$gameID]);
        var_dump($result);

        $response = [
            "status"=>true,
            "message"=>"globalscore hämatads",
            "highscore" => $result
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>      