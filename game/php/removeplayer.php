<?php
    $input = json_decode(file_get_contents("../json/removeplayer-request.json"), true);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();
        
        $remove = $input["removeID"];
      

        $sql = "DELETE FROM player WHERE playerID = ?";
        if($connection->execute($sql, [$remove]) === false){
            throw new Exception("Kunde inte ta bort spelare");
        }
        
        $response = [
            "status"=>true,
            "message"=>"Spelare har tagits bort"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>

