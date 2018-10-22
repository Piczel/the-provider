<?php
    $input = json_decode(file_get_contents("../json/get-participants-request.json"), true);
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

        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }

        $sql = "SELECT 1 FROM blog WHERE forAdminID = ? AND blogID = ?";
        $result = $connection->query($sql,[$account,$blog]);
        if(count($result) != 1){
            throw new Exception("Inte adminnistratör för blogg");
        }

        $sql = "SELECT username FROM blog_account INNER JOIN account ON account.accountID = blog_account.forAccountID WHERE forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
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