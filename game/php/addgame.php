<?php
    $input = json_decode(file_get_contents("../json/addgame-request.json"), true);
    
    try{

        include"../../utility/utility.php";
        $connection = new DBConnection();

        $spelnamn = $input["name"];

        $sql = "INSERT INTO game(`name`) VALUES (?)";
        if($connection->execute($sql, [$spelnamn]) === false){
            throw new Exception("Kunde inte lägga till spel");
        }


        $response = [
            "status"=>true,
            "message"=>"spel tillagt"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?> 