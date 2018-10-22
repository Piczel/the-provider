<?php
    $input = json_decode(file_get_contents("../json/remove-from-blog-request.json"), true);
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
        $remove = $input["removeAccountID"];
        $blog = $input["blogID"];
        $activated_tp = $input["activated_tp"];
        $activated_user = $input["activated_user"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = ? AND activated_user = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$activated_tp,$activated_user,$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT forAccountID FROM admin_blog WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$account,$blog]);
        if(count($result) != 1){
            throw new Exception("Inte din blogg");
        }

        $sql = "SELECT forAccountID FROM blog_account WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$remove,$blog]);
        if(count($result) != 1){
            throw new Exception("Användaren är redan borttagen");
        }

        $sql = "DELETE FROM blog_account WHERE forBlogID = ? AND forAccountID = ?";
        if($connection->execute($sql,[$blog,$remove]) === true){
            $response = [
                "status"=>true,
                "message"=>"Användare borttagen"
            ];
        }else{
            throw new Exception("Kunde inte ta bort användare");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>