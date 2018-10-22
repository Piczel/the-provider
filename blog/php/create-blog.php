<?php
    $input = json_decode(file_get_contents("../json/create-blog-request.json"), true);
    try{
        include "../../utility/utility.php";
        Input::validate($input,[
            "accountID"=>null,
            "token"=>20,
            "title"=>50
        ]);
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $account = $input["accountID"];
        $title = $input["title"];

        $sql = "INSERT INTO blog(title, forAdminID) VALUES (?,?)"; //? anger värden, ett ? = ett värde
        if($connection->execute($sql, [$title,$account]) === false){//skicka med värdena som en array när frågan körs
            throw new Exception("Kunde inte skapa blogg");
        }

        $sql = "SELECT blogID FROM blog WHERE forAdminID = ?";
        $result = $connection->query($sql,[$account]);
        if(count($result) != 1){
            throw new Eception("Syntax fel");
        }
            $blog = $result[0]["blogID"];

        $sql = "INSERT INTO admin_blog(forAccountID,forBlogID) VALUES(?,?)";
        if($connection->execute($sql,[$account,$blog]) === false){
            throw new Exception("Syntax fel 2");
        }

        $sql = "INSERT INTO blog_account(forAccountID,forBlogID)";
        if($connection->execute($sql,[$account,$blog]) === true){
            $response = [
                "status"=>true,
                "message"=>"Du har blivit ägare av en ny blogg"
            ];
        }else{
            throw new Exception("Kunde inte lägga till konto");
        }

        $response = [
            "status"=>true,
            "message"=>"Blogg skapad"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>