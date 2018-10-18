<?php
    $input = json_decode(file_get_contents("../json/create-post-request.json"), true);
    try{
        include "../../utility/utility.php";
        include "../utility.php";
        $generated = Token::generate('User', 'Användarens hemliga lösenord');
        $token = $generated['token'];
        $input['token'] = $token;
        Input::validate($input,[
            "forAccountID"=>null,
            "token"=>20,
            "title"=>50
        ]);
        if(!Token::verify($input["forAccountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

    $blog = $input["forBlogID"];
    $account = $input["forAccountID"];
    $title = $input["title"];
    $date = $input["date"];
    $content = $input["content"];

    $sql = "SELECT * FROM blog_account WHERE forAccountID = ? AND forBlogID = ?";
    $result = $connection->query($sql,[$account,$blog]);
    if(count($result) == 1){
        $sql = "INSERT INTO post(title, date, content, forBlogID, forAccountID) VALUES (?,?,?,?,?)"; 
        if($connection->insert($sql, [$title, $date, $content, $blog, $account]) === false){
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