<?php
    $input = json_decode(file_get_contents("../json/get-all-posts-request.json"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $blog = $input["blogID"];
            
        $sql = "SELECT * FROM post WHERE forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"Alla inlägg hämtade",
                "posts"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hitta inlägg");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>