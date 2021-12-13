<?php 

    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';

    $db_connect=sqlCheck();
    
    $password=$_POST['password'];
    $newPassword=$_POST['new-password'];
    $memberId=$_SESSION['ID'];

    $sql="SELECT Member_Password FROM CommunityMember where (Member_ID='$memberId')";

    $selectResult=mysqli_query($db_connect,$sql);
    $memberPassword=mysqli_fetch_array( $selectResult);


    // $sql= "UPDATE PostTable SET Post_Image_Route=null ,Post_Update='$nowDateSave',Post_Title = '$title' ,Post_Content = '$content' WHERE (Post_Number = '$serialNum')";
    // $update_result=mysqli_query($db_connect,$sql);
    if($password==$memberPassword['Member_Password']){

        $sql="UPDATE CommunityMember SET Member_Password='$newPassword' WHERE(Member_ID='$memberId')";
        $updateResult=mysqli_query($db_connect,$sql);
        if($updateResult){
           session_destroy();
           echo"<script>
           alert('비밀번호 변경되었습니다. 변경된 비밀번호로 재 로그인 해주세요');
           location.href='../PHP/login.html';
           </script>";
        }
        else{
            echo "실패";
        }
        
    }
    else{
      echo "<script>
      alert('기존비밀번호와 다릅니다');
      location.href='../PHP/passwordChange.html';
      </script>";
    }
    
  
?>