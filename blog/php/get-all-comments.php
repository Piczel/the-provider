<?php
    $input = json_decode(file_get_contents("php://input"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

        $blog = $input["blogID"];
        $post = $input["postID"];
    
        $sql = "SELECT * FROM admin_blog WHERE activated_tp = 1 AND activated_user = 1 AND forBlogID = ?";
        $result = $connection->query($sql,[$blog]);
        if(count($result) != 1){
            throw new Exception("Bloggen är ej aktiverad");
        }
        
        $sql = "SELECT * FROM post WHERE postID = ?";
        $result = $connection->query($sql,[$post]);
        if(count($result) != 1){
            throw new Exception("Kunde inte hitta post");
        }
        
        $sql = "SELECT content,date FROM comment WHERE forPostID = ?";
        $result = $connection->query($sql,[$post]);
        if(count($result) >= 1){
            $response = [
                "status"=>true,
                "message"=>"Alla kommentarer hämtade",
                "posts"=>$result
            ];
        }else{
            throw new Exception("Kunde inte hitta kommentarer");
        }
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response);
?>