<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "accountID"=>null,
            "token"=>20
        ]);
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $input["accountID"];
        $blog = $input["blogID"];
        $post = $input["postID"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT * FROM post INNER JOIN blog_account ON post.forBlogID = blog_account.forBlogID WHERE post.postID = ? AND blog_account.forAccountID = ?";
        $result = $connection->query($sql,[$post,$account]);
        if(count($result) != 1){
            throw new Exception("Post är redan borttagen");
        }
        
        $sql = "DELETE FROM comment WHERE forPostID = ?";
        if($connection->execute($sql,[$post]) === false){
            throw new Exception("Kunde inte ta bort kommentarer");
        }

        $sql = "DELETE FROM post WHERE postID = ?";
        if($connection->execute($sql, [$post]) === false){
            throw new Exception("Kunde inte ta bort post");
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
    echo json_encode($response);
?>