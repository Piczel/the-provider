<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $accountID = $input["accountID"];

        $sql = "SELECT * FROM admin_game WHERE activated_tp = 1 AND activated_user = 1 AND forAccountID = ?";
        $result = $connection->query($sql,[$accountID]);
        if(count($result) != 1){
            throw new Exception("spelet är inte aktiverat");
        }

        $sql = "SELECT gameID FROM game INNER JOIN admin_game ON forGameID = gameID WHERE forAccountID = ?";
        $result = $connection->query($sql,[$forAccountID]);
        if(count($result)<1){
            throw new exception("Du har inget spel");
        }
        $response = [
            "status"=>true,
            "message"=>"gameID hämtat",
            "gameID"=>$result[0]["gameID"]
        ];
        

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>