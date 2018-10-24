<?php
    $input = json_decode(file_get_contents("../json/addscore-request.json"), true);
   
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $läggatillpoäng = $input["score"];
        $date = $input["datum"];
        $forGameID = $input["forGameID"];
        $forPlayerID= $input["forPlayerID"];
        $sql = "INSERT INTO score (score, `date`,forPlayerID,forGameID) VALUES (?,?,?,?)";
        if($connection->execute($sql, [$läggatillpoäng,$date,$forGameID,$forPlayerID]) === false){
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