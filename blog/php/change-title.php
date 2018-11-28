<?php
    try{
        include "../../utility/utility.php";
        Input::validate($_POST,[
            "accountID"=>null,
            "token"=>20
        ]);
        if(!Token::verify($_POST["accountID"], $_POST["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $_POST["accountID"];
        $title = $_POST["title"];
        $blog = $_POST["blogID"];
    
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

        $sql = "UPDATE blog SET title = ? WHERE blogID = ?";
        if($connection->execute($sql,[$title,$blog]) === false){
            throw new Exception("Kunde inte uppdatera title");
        }

        $response = [
            "status"=>true,
            "message"=>"Titel uppdaterad"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>