<?php
    $input = json_decode(file_get_contents("../json/addstate-response.json"), true);
    var_dump($input);
    try{

        include"../../utility/utility.php";
        $connection = new DBConnection();

        
        $sid2 = $input["sid2"];

        $sql = "INSERT INTO  stat(sid2) VALUES (?)";
        if($connection->insert($sql, [$sid2]) === false){
            throw new Exception("Kunde inte lägga till state");
        }


        $response = [
            "status"=>true,
            "message"=>"en state har lagt till"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response); 
    
?>