<?php 
  require_once('./dbConnect.php');
  $db_connect= sqlcheck();
  if($db_connect){
   // echo "connect : 성공 <br>";
}
else{
    die("DB 연결 실패");
}


$id=$_POST['id'];
$password=$_POST['password'];
$nickName=$_POST['nickName'];
$email=$_POST['email'];

$sql = "INSERT INTO CommunityMember (Member_ID,Member_Password,Member_NickName,Member_Email) 
Values( '$id', '$password', '$nickName', '$email')";

$insert_result = mysqli_query($db_connect,$sql);
if($insert_result===TRUE){

    ?>
<script>
    alert('회원가입 성공하셨습니다.');
    document.location.href = 'login.html';
</script>

<?php
}
else{
  echo mysqli_error($db_connect);
}
?>
<?php 
// if($db_connect->query($sql)===TRUE){
//     echo "New record created successfully";
// }
// else{
//     echo "Error :".$sql ."<br>". $db_connect->error;
// }



?>