<?php
    $input = json_decode(file_get_contents("../json/remove-from-blog-request.json"), true);
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