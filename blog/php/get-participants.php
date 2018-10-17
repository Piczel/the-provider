<?php
    $input = json_decode(file_get_contents("../json/get-participants-request.json"), true);
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

        $sql = "SELECT * FROM blog WHERE uid = ? AND bid = ?";
        $result = $connection->query($sql,[$userid,$blogid]);
        if(count($result) != 1){
            throw new Exception("Inte adminnistratör för blogg");
        }

        $sql = "SELECT * FROM blogger INNER JOIN user ON user.uid = blogger.uid WHERE bid = ?";
        $result = $connection->query($sql,[$blogid]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"Alla medlemmar hämtade",
                "participants"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hämta medlemmar");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>