<?php
    $input = json_decode(file_get_contents("../json/invite-user-request.json"), true);
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