<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
     require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
     $date=date("Y-m-d H:i:s");
     $date=$date.' (수정됨)';
     
     
     
     $db_connect=sqlCheck();
     $postData= json_decode(file_get_contents('php://input'));
     //$replyContentPrintJS = str_replace("\\n","\r\n" ,$postData->replyContent);
     $sql="UPDATE PostReplyTable SET Reply_Content='$postData->replyContent', Reply_Reg_Update='$date' WHERE( no = '$postData->replyNum')";
     $updateResult=mysqli_query($db_connect,$sql);

     if($updateResult){
         echo 'true';
     }
     else{
        echo mysqli_error($db_connect);
     }
?>