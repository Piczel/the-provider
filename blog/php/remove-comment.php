<?php
    $input = json_decode(file_get_contents("../json/remove-comment-request.json"), true);
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
        $commentid = $input["cid"];
        
        $sql = "SELECT * FROM comment WHERE uid = ? AND cid = ?";
        $result = $connection->query($sql,[$userid,$commentid]);
        if(count($result) == 1){
            $sql = "DELETE FROM comment WHERE cid = ?";
            if($connection->insert($sql, [$commentid]) === false){
                throw new Exception("Kunde inte ta bort kommentar");
            }
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
