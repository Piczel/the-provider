<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $score = $input["score"];
        $date = $input["date"];
        $forGameID = $input["forGameID"];
        $forPlayerID= $input["forPlayerID"];

        $sql = "SELECT * FROM admin_game WHERE activated_tp = 1 AND activated_user = 1 AND forGameID = ?";
        $result = $connection->query($sql,[$forGameID]);
        if(count($result) != 1){
            throw new Exception("spelet är inte aktiverat");
        }

        $sql = "INSERT INTO score (score,`date`,forGameID,forPlayerID) VALUES (?,?,?,?)";
        if($connection->execute($sql, [$score,$date,$forGameID,$forPlayerID]) === false){
            throw new Exception("Kunde inte lägga till poäng");
        }


        $response = [
            "status"=>true,
            "message"=>"poäng tillagt"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>