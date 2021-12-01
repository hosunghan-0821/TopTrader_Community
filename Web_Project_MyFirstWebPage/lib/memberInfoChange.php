<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';

    $db_connect=sqlCheck();
    $post_data= json_decode(file_get_contents('php://input'));
   

    if($post_data->check=="Member_NickName_Change"){
        $nickName=$_SESSION['nickName'];
        $sql="UPDATE CommunityMember SET Member_NickName='$post_data->nickName' WHERE(Member_NickName='$nickName')";
        $update_query=mysqli_query($db_connect,$sql);
        if($update_query){
            echo 'true';
         
            $_SESSION['nickName'] =$post_data->nickName;
            $asd=$_SESSION['nickName'];
        }
        else{
            echo 'false';
        }
    }
    else if($post_data->check=="Member_Out"){
        $sql="DELETE FROM CommunityMember WHERE(Member_ID='$post_data->id')";
        
        $delete_result=mysqli_query($db_connect,$sql);
        if($delete_result){
            session_destroy();
            echo "true";

        }
        else{
        
        echo "false";
        }

    }
  
    

?>