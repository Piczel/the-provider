<?php
    $input = json_decode(file_get_contents("../json/remove-post-request.json"), true);
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
        $postid = $input["pid"];

        $sql = "SELECT * FROM post 
        INNER JOIN blogger 
        ON post.bid = blogger.bid 
        WHERE post.pid = ? 
        AND blogger.uid = ?";
        $result = $connection->query($sql,[$postid,$userid]);
        if(count($result) == 1){
            $sql = "DELETE FROM post WHERE pid = ?";
            if($connection->insert($sql, [$postid]) === false){
                throw new Exception("Kunde inte ta bort post");
            }
        }

        $response = [
            "status"=>true,
            "message"=>"Post borttagen"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($result);
?>