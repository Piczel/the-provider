<?php
    $input = json_decode(file_get_contents("../json/create-blog-request.json"), true);
    try{

        include "../database/database.php";
        include "../database/utility.php";
        Input::validate($input,[
            "adminID"=>null,
            "token"=>20,
            "title"=>50
        ]);
        Token::verify($input["adminID"],$input["token"]);
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