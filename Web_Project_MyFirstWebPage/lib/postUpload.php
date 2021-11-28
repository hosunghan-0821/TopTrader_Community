<?php
require_once("../lib/dbConnect.php");
require_once("../lib/session.php");

$db_connect=sqlCheck();
if($loginCheck==="false"){
    echo" '로그인 안하고 글쓰는 것은 불가능합니다' ";
    exit;
}

$title=$_POST['title'];
$content=$_POST['textarea'];
$tempFile = $_FILES['imgFile']['tmp_name'];


//이미지가 없을경우 
if($tempFile==null){

}

//이미지가 존재할 경우 서버에 저장하고, 그 경로를 db에 옮겨담기
else{

    $fileTypeExt = explode("/", $_FILES['imgFile']['type']);
    $fileType = $fileTypeExt[0];
    $fileExt = $fileTypeExt[1];
    $resFile ="../RESOURCE/img/{$_FILES['imgFile']['name']}";
    $imageupload=move_uploaded_file($tempFile,$resFile);

    if($imageupload==true){
    echo "<script>
    alert('서버 이미지 업로드성공')
    </script>";
    }

    else{
        echo "posting 실패";
    }
}




?>