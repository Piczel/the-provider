<?php
    $input = json_decode(file_get_contents("../json/remove-blog-request.json"), true);
    try{
        include "../database/database.php";
        include "../database/utility.php";
        Input::validate($input,[
            "adminID"=>null,
            "token"=>20
        ]);
        Token::verify($input["adminID"],$input["token"]);
        $connection = new DBConnection();

        $blogid = $input["bid"];
        
        $sql = "DELETE FROM blog WHERE bid = ?";
        if($connection->insert($sql, [$blogid]) === false){
            throw new Exception("Kunde inte ta bort blogg");
        }

        $response = [
            "status"=>true,
            "message"=>"Blogg borttagen"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>