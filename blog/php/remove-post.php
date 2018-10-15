<?php
    $input = json_decode(file_get_contents("../json/remove-post-request.json"), true);
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