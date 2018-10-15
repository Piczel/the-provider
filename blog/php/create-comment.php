<?php
    $input = json_decode(file_get_contents("../json/create-comment-request.json"), true);
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
        $date = $input["date"];
        $text = $input["text"];

        $sql = "INSERT INTO comment(uid,pid,date,text) VALUES (?,?,?,?)";
        if($connection->insert($sql, [$userid,$postid,$date,$text]) === false){
            throw new Exception("Kunde inte lägga till kommentar");
        }

        $response = [
            "status"=>true,
            "message"=>"Kommenterad"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>