<?php
    $input = json_decode(file_get_contents("../json/get-all-posts-request.json"), true);
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
            
        $sql = "SELECT * FROM post WHERE bid = ?";
        $result = $connection->query($sql,[$blogid]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"Alla poster hämtade",
                "posts"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hämta inlägg");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>