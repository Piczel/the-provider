<?php
    $input = json_decode(file_get_contents("../json/create-post-request.json"), true);
    try{
        include "../database/database.php";
        include "../database/utility.php";
        Input::validate($input,[
            "adminID"=>null,
            "token"=>20,
            "title"=>50
        ]);
        Token::verify($input["adminID"],$input["token"]);
        $connection = new DBConnection();

    $blogid = $input["bid"];
    $userid = $input["uid"];
    $title = $input["title"];
    $date = $input["date"];
    $content = $input["content"];

    $sql = "SELECT * FROM blogger WHERE uid = ? AND bid = ?";
    $result = $connection->query($sql,[$userid,$blogid]);
    if(count($result) == 1){
        $sql = "INSERT INTO post(title, date, text, bid, uid) VALUES (?,?,?,?,?)"; 
        if($connection->insert($sql, [$title, $date, $content, $blogid, $userid]) === false){
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