<?php
    $input = json_decode(file_get_contents("../json/create-blog-request.json"), true);
    try{
        include "../../utility/utility.php";
        include "../utility.php";
        $generated = Token::generate('User', 'Användarens hemliga lösenord');
        $token = $generated['token'];
        $input['token'] = $token;
        Input::validate($input,[
            "adminID"=>null,
            "token"=>20,
            "title"=>50
        ]);
        if(!Token::verify($input["adminID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $admin = $input["adminID"];
        $title = $input["title"];

        $sql = "INSERT INTO blog(title, forAccountID) VALUES (?,?)"; //? anger värden, ett ? = ett värde
        if($connection->execute($sql, [$title,$admin]) === false){//skicka med värdena som en array när frågan körs
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