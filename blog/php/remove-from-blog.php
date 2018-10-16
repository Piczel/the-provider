<?php
    $input = json_decode(file_get_contents("../json/remove-from-blog-request.json"), true);
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
        $removeid = $input["removeid"];
        $blogid = $input["bid"];

        $sql = "SELECT uid FROM blogger WHERE uid = ? AND bid = ?";
        $result = $connection->query($sql,[$userid,$blogid]);
        if(count($result) != 1){
            throw new Exception("Inte din blogg");
        }

        $sql = "SELECT uid FROM blogger WHERE uid = ? AND bid = ?";
        $result = $connection->query($sql,[$removeid,$blogid]);
        if(count($result) != 1){
            throw new Exception("Användaren är redan borttagen");
        }

        $sql = "DELETE FROM blogger WHERE bid = ? AND uid = ?";
        if($connection->insert($sql,[$blogid,$removeid]) === true){
            $response = [
                "status"=>true,
                "message"=>"Användare borttagen"
            ];
        }else{
            throw new Exception("Kunde inte ta bort användare");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>