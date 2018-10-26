<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $forGameID = $input["gameID"];

        $sql = "SELECT * FROM admin_game WHERE activated_tp = 1 AND activated_user = 1 AND forGameID = ?";
        $result = $connection->query($sql,[$forGameID]);
        if(count($result) != 1){
            throw new Exception("spelet är inte aktiverat");
        }

        $sql = "SELECT playerID, `name` FROM player WHERE forGameID = ?";
        $result = $connection->query($sql,[$forGameID]);
        
        $response = [
            "status"=>true,
            "message"=>"spelare hämtade",
            "score"=>$result
        ];
        

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>
