<?php 

    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    $db_connect=sqlCheck();

    //fetch를 통해 들어온 데이터 받고 변수들로 각각지정
    $post_data= json_decode(file_get_contents('php://input'));
    $serialNum=$post_data->num;
    $imageRoute=$post_data->route;
    
    //db에 저장되어있는 imageRoute에 접근해서 해당경로가 존재하다면 삭제.
    $selectSql="SELECT Post_Image_Route FROM PostTable where (Post_Number='$serialNum')";
    $selectQuery=mysqli_query($db_connect,$selectSql);
    $asd12;
    if($selectQuery){
        $Data=mysqli_fetch_array($selectQuery);
        $imageUpdateRoute=$Data['Post_Image_Route'];
        $imageRouteOriginal=$imageRoute;
        $imageRoute=$imageRoute.'-';
       
        // str_replace("찾을 문자", "변경할 문자", "해당하는 문자열");
        // 해당경로 제거하고 update DB에 업데이트 해주기
        // 서버에있는 파일도 삭제해야함
        $imageUpdateRoute=str_replace($imageRoute, '', $imageUpdateRoute);
        $updateSql="UPDATE PostTable SET Post_Image_Route='$imageUpdateRoute' WHERE (Post_Number = '$serialNum')";
        $updateQuery=mysqli_query($db_connect,$updateSql);
        if($updateQuery){
            //이미지경로 제거 업데이트성공
            unlink($imageRouteOriginal);
            echo "true";
        }
        else{
            echo "false";
        }

        
    }



?>