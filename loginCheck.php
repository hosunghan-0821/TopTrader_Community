<?php
session_start();
require_once("./dbConnect.php");

$db_connect = sqlcheck();
 
$id=$_POST['id'];
$password=$_POST['password'];
 
 
//  if($db_connect){
//     echo "connect : 성공 <br>";
// }
// else{
//     echo "disconnect :실패 <br>";
// }

$select_query="SELECT Member_ID, Member_Password,Member_NickName FROM CommunityMember";
$select_result = mysqli_query($db_connect,$select_query);
$nickName;
while($Data = mysqli_fetch_array($select_result)){

    if($Data['Member_ID']===$id){
        if($Data['Member_Password']===$password){
            $check=true;
            $nickName=$Data['Member_NickName'];
            break;
        }
    }
    $check=false;
}
if($check==true){
    //header('Location: ./myHtml.html');
    $_SESSION['is_login'] = true;
    $_SESSION['nickname'] = $nickName;
    echo" <script>
    alert('로그인 성공')
    document.location.href='./myHtml.php';
    </script>";
    exit;
}
else{
    echo "<script>
    alert('로그인 실패'); 
    document.location.href='login.html';
    </script>";
}
 
// echo "id : ".$id."<br/>";
// echo "password : ".$password;

// if($id=="winsomed96"){
//     if($password=="ghtjd114"){
//         header('Location: ./myHtml.html');
//     }
//     else{
//         echo "wrong id or pw";
//     }
 
// }
// else{
//     echo "wrong id or pw";
// }

?>