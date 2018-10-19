<?php
    $input = json_decode(file_get_contents("../json/get-own-blogs-request.json"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "accountID"=>null,
            "token"=>20,
        ]);
        echo $input["token"];
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $input["accountID"];

        $sql = "SELECT * FROM blog INNER JOIN blog_account WHERE blog_account.forBlogID = blog.blogID AND forAccountID = ?";
        $result = $connection->query($sql,[$account]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"Bloggar hämtade",
                "blogs"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hämta bloggar");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>