<?php
    $input = json_decode(file_get_contents("../json/remove-post-request.json"), true);
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
        $post = $input["postID"];
        $activated_tp = $input["activated_tp"];
        $activated_user = $input["activated_user"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = ? AND activated_user = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$activated_tp,$activated_user,$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT * FROM post INNER JOIN blog_account ON post.forBlogID = blog_account.forBlogID WHERE post.postID = ? AND blog_account.forAccountID = ?";
        $result = $connection->query($sql,[$post,$account]);
        if(count($result) != 1){
            throw new Exception("Post är redan borttagen");
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