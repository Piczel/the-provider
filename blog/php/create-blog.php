<?php
    $input = json_decode(file_get_contents("../json/create-blog-request.json"), true);
    var_dump($input);
    try{
        /*session_start();
        if(isset($_SESSION["signedInUserid"])){
            throw new Exception("Inte inloggad");
        }
        if($input["uid"] != $_SESSION["signedInUserid"]){
            throw new Exception("Inte inloggad");
        }*/

        include "../database/database.php";
        $connection = new DBConnection();

        $title = $input["title"];

        $sql = "INSERT INTO blog(title) VALUES (?)"; //? anger värden, ett ? = ett värde
        if($connection->insert($sql, [$title]) === false){//skicka med värdena som en array när frågan körs
            throw new Exception("Kunde inte skapa blogg");
        }

        $response = [
            "status"=>true,
            "message"=>"Blogg skapad"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>