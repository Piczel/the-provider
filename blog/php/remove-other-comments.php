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
        $blog = $_POST["blogID"];
        $comment = $_POST["commentID"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT forAccountID FROM blog_account WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$account,$blog]);
        if(count($result) != 1){
            throw new Exception("Inte din blogg");
        }

        $sql = "DELETE FROM comment WHERE commentID = ?";
        if($connection->execute($sql,[$comment]) === false){
            throw new Exception("Kunde inte ta bort kommentar");
        }

        $response = [
            "status"=>true,
            "message"=>"Kommentar borttagen"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>

