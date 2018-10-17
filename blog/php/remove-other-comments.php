<?php
    $input = json_decode(file_get_contents("../json/remove-other-comments-request.json"), true);
    try{
        include "../database/database.php";
        include "../database/utility.php";
        Input::validate($input,[
            "adminID"=>null,
            "token"=>20
        ]);
        Token::verify($input["adminID"],$input["token"]);
        $connection = new DBConnection();

        $userid = $input["uid"];
        $blogid = $input["bid"];
        $postid = $input["pid"];
        $commentid = $input["cid"];

        $sql = "SELECT uid FROM blogger WHERE uid = ? AND bid = ?";
        $result = $connection->query($sql,[$userid,$blogid]);
        if(count($result) != 1){
            throw new Exception("Inte din blogg");
        }

        $sql = "SELECT * FROM comment WHERE pid = ? AND cid = ?";
        $result = $connection->query($sql,[$postid,$commentid]);
        if(count($result) != 1){
            throw new Exception("Kunde inte hitta kommentar");
        }

        $sql = "DELETE FROM comment WHERE cid = ?";
        if($connection->insert($sql,[$commentid]) === false){
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

