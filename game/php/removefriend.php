<?php
    $input = json_decode(file_get_contents("../json/removefriend-request.json"), true);
   
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();

        $friendshipID = $input["friendshipID"];

        $sql = "DELETE FROM friendship WHERE friendshipID = ?";
        if($connection->execute($sql, [$friendshipID]) === false){
            throw new Exception("Kunde inte ta bort vän");
        }


        $response = [
            "status"=>true,
            "message"=>"vän borttagen"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>