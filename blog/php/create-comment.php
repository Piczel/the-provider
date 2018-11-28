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
        $post = $_POST["postID"];
        $date = $_POST["date"];
        $content = $_POST["content"];
        $blog = $_POST["blogID"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT forBlogID,forAccountID FROM block_account WHERE forBlogID = ? AND forAccountID = ?";
        $result = $connection->query($sql,[$blog,$account]);
        if(count($result) == 1){
            throw new Exception("Du är blockerad från denna blogg");
        }

        $sql = "INSERT INTO comment(content,date,forPostID,forAccountID) VALUES (?,?,?,?)";
        if($connection->execute($sql, [$content,$date,$post,$account]) === false){
            throw new Exception("Kunde inte lägga till kommentar");
        }

        $response = [
            "status"=>true,
            "message"=>"Kommenterad"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>