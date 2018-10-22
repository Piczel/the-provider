<?php
    $input = json_decode(file_get_contents("../json/remove-other-comments-request.json"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "accountID"=>null,
            "token"=>20
        ]);
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $input["accountID"];
        $blog = $input["blogID"];
        $comment = $input["commentID"];

        $sql = "SELECT forAccountID FROM blog_account WHERE forAccountID = ? AND forBlogID = ?";
        $result = $connection->query($sql,[$account,$blog]);
        if(count($result) != 1){
            throw new Exception("Inte din blogg");
        }

        $sql = "DELETE FROM comment WHERE commentID = ?";
        if($connection->execute($sql,[$comment]) === false){
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

