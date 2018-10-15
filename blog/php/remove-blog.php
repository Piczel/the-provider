<?php
    $input = json_decode(file_get_contents("../json/remove-blog-request.json"), true);
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

        $blogid = $input["bid"];
        
        $sql = "DELETE FROM blog WHERE bid = ?";
        if($connection->insert($sql, [$blogid]) === false){
            throw new Exception("Kunde inte ta bort blogg");
        }

        $response = [
            "status"=>true,
            "message"=>"Blogg borttagen"
        ];

    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>