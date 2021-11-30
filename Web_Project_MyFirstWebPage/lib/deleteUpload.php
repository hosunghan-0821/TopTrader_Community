<?php

    require_once('../lib/dbConnect.php');
    $db_connect=sqlCheck();

    $post_data= json_decode(file_get_contents('php://input'));

    //여기서 해당 이미지 파일 경로 찾아서 지우고 그 다음 mysql 에서 전체글 삭제
    $sql="SELECT Post_Image_Route FROM PostTable where (Post_Number='$post_data->num')";
    $select_query=mysqli_query($db_connect,$sql);
    if($select_query){
        
        $Data =mysqli_fetch_array($select_query);
        if( $Data['Post_Image_Route'] !== null){
            unlink($Data['Post_Image_Route']);
        }
       
    }

    


    //여기서 해당 하는 row찾아서 delete result;
    $sql="DELETE FROM PostTable WHERE (Post_Number='$post_data->num')";
    $delete_result=mysqli_query($db_connect,$sql);
    if($delete_result){
        echo "true";
    }
    else{
        
        echo "false";
    }

    //DELETE FROM `hosungDB`.`PostTable` WHERE (`Post_Number` = '35');




?>