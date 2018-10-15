<?php
    $input = json_decode(file_get_contents("../json/create-post-request.json"), true);
    var_dump($input);
    try{
        /*session_start();
        if(isset($_SESSION["signedInUserid"])){
            throw new Exception("Inte inloggad");
        }
        if($input["uid"] != $_SESSION["signedInUserid"]){
            throw new Exception("Inte inloggad");
        }*/

    include "../database/database.php";
    $connection = new DBconnection();

    $blogid = $input["bid"];
    $userid = $input["uid"];
    $title = $input["title"];
    $date = $input["date"];
    $text = $input["text"];

    $sql = "SELECT * FROM blogger WHERE uid = ? AND bid = ?";
    $result = $connection->query($sql,[$userid,$blogid]);
    if(count($result) == 1){
        $sql = "INSERT INTO post(title, date, text, bid, uid) VALUES (?,?,?,?,?)"; 
        if($connection->insert($sql, [$title, $date, $text, $blogid, $userid]) === false){
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