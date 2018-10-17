<?php
    $input = json_decode(file_get_contents("../json/invite-user-request.json"), true);
    try{
        include "../database/database.php";
        include "../database/utility.php";
        Input::validate($input,[
            "adminID"=>null,
            "token"=>20,
            "email"=>50
        ]);
        Token::verify($input["adminID"],$input["token"]);
        $connection = new DBconnection();

        $userid = $input["uid"];
        $email = $input["invite-email"];
        $blogid = $input["bid"];

        $sql = "SELECT uid FROM user WHERE email = ?";
        $result = $connection->query($sql,[$email]);
        if(count($result) != 1){
            throw new Exception("Kunde inte hitta konto");
        }

        $inviteid = $result[0]["uid"];

        $sql = "SELECT uid FROM blogger WHERE uid = ? AND bid = ?";
        $result = $connection->query($sql,[$userid,$blogid]);
        if(count($result) != 1){
            throw new Exception("Inte din blogg");
        }

        $sql = "SELECT 1 FROM blogger WHERE uid = ? AND bid = ?";
        $result = $connection->query($sql,[$inviteid,$blogid]);
        if(count($result) != 0){
            throw new Exception("Användare redan tillagd");
        }

        $sql = "INSERT INTO blogger(uid,bid) VALUES (?,?)";
        if($connection->insert($sql,[$inviteid,$blogid]) === true){
            $response = [
                "status"=>true,
                "message"=>"Inbjudan skickad"
            ];
        }else{
            throw new Exception("Kunde inte bjuda in konto");
        }

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
echo json_encode($response);
?>