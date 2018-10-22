<?php
    $input = json_decode(file_get_contents("../json/create-comment-request.json"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "token"=>20,
            "title"=>50
        ]);
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $input["accountID"];
        $post = $input["postID"];
        $date = $input["date"];
        $content = $input["content"];

        $sql = "INSERT INTO comment(content,date,forPostID,forAccountID) VALUES (?,?,?,?)";
        if($connection->execute($sql, [$content,$date,$post,$account]) === false){
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