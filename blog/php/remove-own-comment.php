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
        $comment = $_POST["commentID"];

        $sql = "SELECT activated_tp,activated_user FROM admin_blog AS a 
        INNER JOIN comment AS c INNER JOIN post AS p 
        WHERE c.commentID = ? AND c.forPostID = p.postID AND p.forBlogID = a.forBlogID
        AND a.activated_tp = 1 AND a.activated_user = 1";
        $result = $connection->query($sql,[$comment]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }
        
        $sql = "SELECT commentID FROM comment WHERE forAccountID = ? AND commentID = ?";
        $result = $connection->query($sql,[$account,$comment]);
        if(count($result) != 1){
            throw new Exception("Inte din kommentar");
        }
        
        $sql = "DELETE FROM comment WHERE commentID = ?";
        if($connection->execute($sql, [$comment]) === false){
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
?>