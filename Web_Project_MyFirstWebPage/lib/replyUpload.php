<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    $db_connect=sqlCheck();
    $nickName=$_SESSION['nickName'];
    $reply=$_POST['reply'];
    $scroll=$_POST['scroll'];
    $postNum=$_POST['postNum'];
    $date=date("Y-m-d H:i:s");

    $sql="INSERT INTO PostReplyTable(Reply_Writer,Reply_Post_Num,Reply_Content,Reply_Reg_Update) 
    Values('$nickName','$postNum','$reply','$date')";
    $insertResult=mysqli_query($db_connect,$sql);
    if($insertResult){
        $sql = "UPDATE PostTable SET Post_Reply_Num = Post_Reply_Num + 1 WHERE Post_Number='$postNum'";
        mysqli_query($db_connect,$sql);
        header('location:../PHP/boardRead.php?num='.$postNum.'&scroll='.$scroll);
    }
    else{
       echo mysqli_error($db_connect);
    }
   
    $check;
    // $sql= "INSERT INTO PostTable (Post_Writer,Post_Category,Post_Title,Post_Content,Post_Image_Route) 
    // VALUES ( '$nickName', '자유게시판', '$title', '$content', null)";
?>