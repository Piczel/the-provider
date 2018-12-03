<?php
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
        $username = $input["username"];
        $blog = $input["blogID"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT forAccountID FROM admin_blog WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$account,$blog]);
        if(count($result) != 1){
            throw new Exception("Inte ägare av blogg");
        }

        $sql = "SELECT accountID FROM account WHERE username = ?";
        $result = $connection->query($sql,[$username]);
        if(count($result) != 1){
            throw new Exception("Kunde inte hitta konto");
        }

        $invite = $result[0]["accountID"];

        $sql = "SELECT 1 FROM blog_account WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$invite,$blog]);
        if(count($result) != 0){
            throw new Exception("Användare redan tillagd");
        }

        $sql = "INSERT INTO blog_account(forAccountID,forBlogID) VALUES (?,?)";
        if($connection->execute($sql,[$invite,$blog]) === true){
            $response = [
                "status"=>true,
                "message"=>"Konto tillagt"
            ];
        }else{
            throw new Exception("Kunde inte lägga till konto");
        }

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>