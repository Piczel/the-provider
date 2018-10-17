<?php
    $input = json_decode(file_get_contents("../json/get-own-blogs-request.json"), true);
    try{
        include "../database/database.php";
        include "../database/utility.php";
        Input::validate($input,[
            "adminID"=>null,
            "token"=>20
        ]);
        Token::verify($input["adminID"],$input["token"]);
        $connection = new DBConnection();

        $userid = $input["uid"];

        $sql = "SELECT * FROM blog INNER JOIN blogger WHERE blogger.bid = blog.bi AND uid = ?";
        $result = $connection->query($sql,[$userid]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"Bloggar hämtade",
                "blogs"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hämta bloggar");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>