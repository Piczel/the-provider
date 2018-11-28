<?php
    try{
        include "../../utility/utility.php";
        Input::validate($_POST,[
            "accountID"=>null,
            "token"=>20,
        ]);
        if(!Token::verify($_POST["accountID"], $_POST["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $_POST["accountID"];
    
        $sql = "SELECT * FROM blog INNER JOIN admin_blog ON forBlogID = blogID WHERE activated_tp = 1 AND activated_user = 1";
        $result = $connection->query($sql);
        if(count($result) < 0){
            throw new Exception("Kunde inte hitta bloggar");
        }

        $sql = "SELECT title,blogID FROM blog INNER JOIN blog_account ON blog_account.forBlogID = blog.blogID WHERE blog_account.forAccountID = ?";
        $result = $connection->query($sql,[$account]);
        if(count($result) < 1){
           throw new Exception("Kunde inte hämta bloggar");
        }
        $response = [
            "status"=>true,
            "message"=>"Bloggar hämtade",
            "blogs"=>$result
        ];
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
?>