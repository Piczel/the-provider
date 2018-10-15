<?php
    $input = json_decode(file_get_contents("../json/create-comment-request.json"), true);
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