<?php
    $input = json_decode(file_get_contents("../json/create-post-request.json"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "accountID"=>null,
            "token"=>20,
            "title"=>50
        ]);
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $blog = $input["blogID"];
        $account = $input["accountID"];
        $title = $input["title"];
        $date = $input["date"];
        $content = $input["content"];

        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$activated_tp,$activated_user,$blog]);
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