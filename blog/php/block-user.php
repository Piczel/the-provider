<?php
    try{
        include "../../utility/utility.php";
        Input::validate($_POST,[
            "token"=>20,
        ]);
        if(!Token::verify($_POST["accountID"], $_POST["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $_POST["accountID"];
        $blog = $_POST["blogID"];
        $block = $_POST["blockID"];

        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT * FROM blog_account WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$account,$blog]);
        if(count($result) != 1){
            throw new Exception("Inte medlem i blogg");
        }   

        $sql = "INSERT INTO block_account(forBlogID,forAccountID) VALUES (?,?)";
        if($connection->execute($sql,[$blog,$block]) === false){
            throw new Exception("Kunde inte blockera användare");
        }

        $response = [
            "status"=>true,
            "message"=>"Användare blockerad"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>