<?php
    $input = json_decode(file_get_contents("../json/addgame-response.json"), true);
    var_dump($input);
    try{

        include"../../utility/utility.php";
        $connection = new DBConnection();

        $spelnamn = $input["spelnamn"];

        $sql = "INSERT INTO spel(spelnamn) VALUES (?)";
        if($connection->insert($sql, [$spelnamn]) === false){
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