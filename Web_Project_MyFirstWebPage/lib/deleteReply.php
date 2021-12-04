<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    
    $db_connect=sqlCheck();
    $postData= json_decode(file_get_contents('php://input'));
    $sql="DELETE FROM PostReplyTable WHERE (no='$postData->replyNum')";
    $deleteResult=mysqli_query($db_connect,$sql);
    if($deleteResult){
        echo 'true';
    }
    else{
        echo mysqli_error($db_connect);
    }
    
?>