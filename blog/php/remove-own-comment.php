<?php
    $input = json_decode(file_get_contents("../json/remove-own-comment-request.json"), true);
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
        $comment = $input["commentID"];
        $activated_tp = $input["activated_tp"];
        $activated_user = $input["activated_user"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = ? AND activated_user = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$activated_tp,$activated_user,$blog]);
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
    echo json_encode($response);
?>