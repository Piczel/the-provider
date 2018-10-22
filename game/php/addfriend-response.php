<?php
    $input = json_decode(file_get_contents("../json/addfriend-response.json"), true);
    var_dump($input);
    try{

        include "../../utility/utility.php";
        $connection = new DBConnection();
        
        
        $sid2 = $input["sid2"];

        $sql = "INSERT INTO vänskap(sid2) VALUES (?)";
        if($connection->insert($sql, [$sid2]) === false){
            throw new Exception("Kunde inte lägga till vän");
        }


        $response = [
            "status"=>true,
            "message"=>"spelare tillagd som vän"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>