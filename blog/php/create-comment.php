<?php
    $input = json_decode(file_get_contents("../json/create-comment-request.json"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "token"=>20,
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
        $blog = $input["blogID"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

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