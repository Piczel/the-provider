<?php
    try{
        include "../../utility/utility.php";
        Input::validate($_POST,[
            "accountID"=>null,
            "token"=>20,
            "title"=>50
        ]);
        if(!Token::verify($_POST["accountID"], $_POST["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $blog = $_POST["blogID"];
        $account = $_POST["accountID"];
        $title = $_POST["title"];
        $date = $_POST["date"];
        $content = $_POST["content"];

        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT * FROM blog_account WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$account,$blog]);
        if(count($result) == 1){
            $sql = "INSERT INTO post(title, date, content, forBlogID, forAccountID) VALUES (?,?,?,?,?)"; 
            if($connection->execute($sql, [$title, $date, $content, $blog, $account]) === false){
                throw new Exception("Kunde inte lägga till post");    
            }
        }else{
            throw new Exception("Inte medlem i blogg");
        }

        $response = [
            "status"=>true,
            "message"=>"Post tillagd"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>