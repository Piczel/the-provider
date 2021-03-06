<?php
    $input = json_decode(file_get_contents("php://input"), true);   
    try{
        include "../../utility/utility.php";
        if(!Token::verify($input["accountID"], $input["token"]))
        {
            throw new Exception("Felaktig token");
        }
        $connection = new DBConnection();

        $playerID = $input["playerID"];

        $sql = "SELECT * FROM player WHERE playerID = ?";
        $result = $connection->query($sql, [$playerID]);
        if(count($result) != 1){
            throw new Exception("Spelaren finns inte");
        }

        $sql = "DELETE FROM score WHERE forPlayerID = ?";
        if($connection->execute($sql, [$playerID]) === false){
            throw new Exception("Kunde inte ta bort spelarens poäng");
    }
    else {
        $sql = "DELETE FROM friendship WHERE forPlayerID = ?";
        if($connection->execute($sql, [$playerID]) === false){
        throw new Exception("Kunde inte ta bort spelare från vänlista1");
        }
        else{
            
            $sql = "DELETE FROM friendship WHERE forFriendID = ?";
            if($connection->execute($sql, [$playerID]) === false){
            throw new Exception("Kunde inte ta bort spelare från vänlista2");
            }
            else{
                
                $sql = "DELETE FROM player WHERE playerID = ?";
                if($connection->execute($sql, [$playerID]) === false){
                throw new Exception("Kunde inte ta bort spelare");
                }
            }
        }
    }

        $response = [
            "status"=>true,
            "message"=>"Spelare borttagen"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>
