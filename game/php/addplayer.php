<?php
    $input = json_decode(file_get_contents("php://input"), true);   
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

        $name = $input["name"];
        $forGameID = $input["forGameID"];

        $sql = "SELECT * FROM player WHERE `name` = ? AND forGameID = ?";
        $result = $connection->query($sql,[$name,$forGameID]);
        if(count($result) == 1){
            throw new Exception("användarnamnet taget");
        }

        $sql = "INSERT INTO player(`name`, forGameID) VALUES (?,?)";
        if($connection->execute($sql, [$name,$forGameID]) === false){
            throw new Exception("Kunde inte lägga till spelare");
        }
        
        $response = [
            "status"=>true,
            "message"=>"Spelare tillagd"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>