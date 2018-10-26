<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "accountID"=>null,
            "token"=>20,
        ]);
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $input["accountID"];
    
        $sql = "SELECT * FROM blog INNER JOIN admin_blog ON forBlogID = blogID WHERE activated_tp = 1 AND activated_user = 1";
        $result = $connection->query($sql);
        if(count($result) < 0){
            throw new Exception("Kunde inte hitta bloggar");
        }

        $sql = "SELECT title,blogID FROM blog INNER JOIN blog_account ON blog_account.forBlogID = blog.blogID WHERE forAccountID = ?";
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
    echo json_encode($response);
?>