<?php
require_once("../lib/dbConnect.php");
require_once("../lib/session.php");

$db_connect=sqlCheck();

if($db_connect){
   
}
else{
     die("DB 연결 실패");
}
if($loginCheck==="false"){
    echo "<script>
    alert('로그인 없이는 글작성이 안됩니다.')
    document.location.href='../PHP/login.html';
    </script>";
    exit;
}
$nickName=$_SESSION['nickName'];
$title=$_POST['title'];
$content=$_POST['textarea'];
$tempFile = $_FILES['imgFile']['tmp_name'];

//이미지 저장용
$nowDate = date("Ymd_His");
//업데이트 관련 변수들
$nowDateSave = date("Y-m-d H:i:s");

$update=$_POST['update'];
$serialNum=$_POST['Post_Num'];

if(!isset($update)){
    $update="false";
    $serialNum=-1;  
}
else{
    $imageClear=$_POST['imageClear'];
}

//업데이트가 아닐경우

if($update=="false"){

    //이미지가 없을경우 

    if($tempFile==null){

    }

    //이미지가 존재할 경우 서버에 저장하고, 그 경로를 db에 옮겨담기
    else{

        $fileTypeExt = explode("/", $_FILES['imgFile']['type']);
        $fileType = $fileTypeExt[0];
        $fileExt = $fileTypeExt[1];
        $fileName=explode(".",$_FILES['imgFile']['name']);
        $resFile="../RESOURCE/img/".$fileName[0].$nowDate.".".$fileName[1];
        //$resFile ="../RESOURCE/img/{$_FILES['imgFile']['name']}".$nowDate;
        $imageupload=move_uploaded_file($tempFile,$resFile);

        if($imageupload==true){
        // echo "<script>
        // alert('서버 이미지 업로드성공')
        // </script>";
        }

        else{
            echo "posting 실패";
        }

    }   
    //이미지가 없을 떄, db 업로드하는 부분
    if(!isset($resFile)){

        $sql= "INSERT INTO PostTable (Post_Writer,Post_Category,Post_Title,Post_Content,Post_Image_Route) 
        VALUES ( '$nickName', '자유게시판', '$title', '$content', null)";
    }

    //이미지가 있을 떄, db 업로드하는 부분
    else{
    
        $sql= "INSERT INTO PostTable (Post_Writer,Post_Category,Post_Title,Post_Content,Post_Image_Route) 
        VALUES ( '$nickName', '자유게시판', '$title', '$content', '$resFile')";
    
    }
    //mysql에 데이터 삽입하는 코드
    $insert_result=mysqli_query($db_connect,$sql);

    //글쓰기 성공
    if($insert_result===TRUE){
        echo "<script>
        alert('글쓰기 성공')
        document.location.href='../PHP/board.php';
        </script>";
    }

    //글쓰기 실패
    else{
        echo mysqli_error($db_connect);
    }
}  

//업데이트 관련 로직 작성
else{

   
    //수정 된 이미지에 아무것도 없을 경우
    if($tempFile==null){

        //이미지를 초기화 했을 경우
        if($imageClear=="true"){

            //원래이미지 경로에 접근해서 이미지 삭제해야함.

            $sql="SELECT Post_Image_Route From  PostTable where (Post_Number = '$serialNum')";
            $select_query=mysqli_query($db_connect,$sql);
            $route=mysqli_fetch_array($select_query);
            unlink($route['Post_Image_Route']);


            $sql= "UPDATE PostTable SET Post_Image_Route=null ,Post_Update='$nowDateSave',Post_Title = '$title' ,Post_Content = '$content' WHERE (Post_Number = '$serialNum')";
            $update_result=mysqli_query($db_connect,$sql);
            
            if($update_result){
                ?>
                <script>
                alert("글 수정 완료되었습니다.")
                document.location.href='../PHP/boardRead.php?num='+"<?php echo $serialNum; ?>";
                </script>
    
                <?php
    
            }
            else{
                echo mysqli_error($db_connect);
            }

        }
        //이미지를 초기화 하지 않고 그냥 유지했을 경우
        else{

            $sql= "UPDATE PostTable SET Post_Update='$nowDateSave',Post_Title = '$title' ,Post_Content = '$content' WHERE (Post_Number = '$serialNum')";
            $update_result=mysqli_query($db_connect,$sql);
            
            if($update_result){
                ?>
                <script>
                alert("글 수정 완료되었습니다.")
                document.location.href='../PHP/boardRead.php?num='+"<?php echo $serialNum; ?>";
                </script>
    
                <?php
    
            }
            else{
                echo mysqli_error($db_connect);
            }
        }

      

    }

    //수정 된 이미지가 존재할 경우 원래 경로와 비교 하는 절차를 갖자.
    else{
        
        $sql="SELECT Post_Image_Route From  PostTable where (Post_Number = '$serialNum')";
        $select_query=mysqli_query($db_connect,$sql);
        $route=mysqli_fetch_array($select_query);
        unlink($route['Post_Image_Route']);


        $fileName=explode(".",$_FILES['imgFile']['name']);
        $resFile="../RESOURCE/img/".$fileName[0].$nowDate.".".$fileName[1];

      
        //수정 된 이미지가 존재할 경우 업로드 시키고, 그 경로를 데이터베이스에 저장

        move_uploaded_file($tempFile,$resFile);
        $sql= "UPDATE PostTable SET Post_Update='$nowDateSave', Post_Image_Route='$resFile' ,Post_Title = '$title', Post_Content = '$content' WHERE (Post_Number = '$serialNum')";
        $update_result=mysqli_query($db_connect,$sql);
        if($update_result){
        
            ?>
            <script>
            alert("글 수정 완료되었습니다.")
            document.location.href='../PHP/boardRead.php?num='+"<?php echo $serialNum; ?>";
            </script>

            <?php
        }
        else{
            echo mysqli_error($db_connect);
        }

        // $resFile ="../RESOURCE/img/{$_FILES['imgFile']['name']}";
        // $select_query="SELECT Post_Image_Route from PostTable where Post_Number=$serialNum and Post_Category='자유게시판' ";
        // $select_result = mysqli_query($db_connect,$select_query);
        // $Data = mysqli_fetch_array($select_result);
        // if($resFile == $Data['Post_Image_Route']){

        // }
        // else{

        // }
    }
   

    // $name=$Data['Post_Writer'];
    // $date=$Data['Post_Date'];
    // $imageRoute=$Data['Post_Image_Route'];
    // $content=$Data['Post_Content'];
    // $title=$Data['Post_Title'];

    //UPDATE `hosungDB`.`PostTable` SET `Post_Title` = '1111', `Post_Content` = '1111' WHERE (`Post_Number` = '10');
    
 
   
    

}

?>

