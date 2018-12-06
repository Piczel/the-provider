<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $blog = $input["blogID"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }
            
        $sql = "SELECT * FROM post WHERE forBlogID = ? ORDER BY postID DESC";
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