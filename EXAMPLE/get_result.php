<?php

// $id =  $_POST["id"];
// $password = $_POST["password"];
// $fname = $_POST["fname"];
// $lname = $_POST["lname"];

// var_dump($_FILES);

// // 이미지 파일 관련한 PHP 코드
// $file=$_FILES['image'];

// // 파일이름  XX.JPG 중 XX 해당
// $srcName=$file['name'];

// //파일 타입 및 확장자.
// $fileTypr=$file['type'];


// //타입 확장자 /로 나누어서 각각 넣어주는 코드
// $filetypeExt=explode("/",$fileTypr);

// //파일 타입 ex) image
// $filetype=$filetypeExt[0];

// //파일 확장자 ex) png,jpg,gif 등등
// $fileExt=$filetypeExt[1];

// //파일 사이즈
// $fileSize=$file['size'];

// //파일 임시이름
// $tmpName=$file['tmp_name'];

// // 확장자 검사
// $extStatus =false;

// switch($fileExt) {
//     case 'jpeg':case 'jpg':case 'gif':case 'bmp':case 'png': $extStatus = true;
//     break;

//     default: echo"이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다.";
//     exit;
//     break;

// }

// //이미지 파일이 맞는지 검사

// if($filetype =='image'){
//     if($extStatus){
//         //임시 파일 옮길 디렉토리 및 파일명
//         $resFile="./img/{$srcName}";
        
//         $imageUpload = move_uploaded_file($tmpName,$resFile);

//         if($imageUpload == true){
//             echo"파일이 정상적으로 업로드 되었습니다 .<br>";
//             echo "<img src='{$resFile}' width='100' />";
//         } else {
//             echo"파일 업로드에 실패하였습니다.";
//         }
//     }
//     else{
//         echo "파일 확장자는 jpg, bmp, gif, png 이어야 합니다.";
// 		exit;
//     }
// }
// else{
//     echo "이미지 파일이 아닙니다.";
// 	exit;
// }


// echo "<hr>";

/*********************************************
* 넘어오는 데이터가 정상인지 검사하기 위한 절차
* 실제 페이지에서는 적용 X
**********************************************/

//$_FILES에 담긴 배열 정보 구하기.


// php 내부 소스에서 html 태그 적용 - 선긋기
echo "<hr>";

/*********************************************
* 실제로 구축되는 페이지 내부.
**********************************************/

// 임시로 저장된 정보(tmp_name)
$tempFile = $_FILES['imgFile']['tmp_name'];

// 파일타입 및 확장자 체크
$fileTypeExt = explode("/", $_FILES['imgFile']['type']);

// 파일 타입 
$fileType = $fileTypeExt[0];

// 파일 확장자
$fileExt = $fileTypeExt[1];

// 확장자 검사
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

// 이미지 파일이 맞는지 검사. 
if($fileType == 'image'){
	// 허용할 확장자를 jpg, bmp, gif, png로 정함, 그 외에는 업로드 불가
	if($extStatus){
		// 임시 파일 옮길 디렉토리 및 파일명
		$resFile = "../img/{$_FILES['imgFile']['name']}";
		// 임시 저장된 파일을 우리가 저장할 디렉토리 및 파일명으로 옮김
		$imageUpload = move_uploaded_file($tempFile,$resFile);
		
		// 업로드 성공 여부 확인
		if($imageUpload == true){
			echo "파일이 정상적으로 업로드 되었습니다. <br>";
            echo "<img src='{$resFile}' width='100' />";
			
		}else{
			echo "파일 업로드에 실패하였습니다.";
		}
	}	// end if - extStatus
		// 확장자가 jpg, bmp, gif, png가 아닌 경우 else문 실행
	else {
		echo "파일 확장자는 jpg, bmp, gif, png 이어야 합니다.";
		exit;
	}	
}	// end if - filetype
	// 파일 타입이 image가 아닌 경우 
else {
	echo "이미지 파일이 아닙니다.";
	exit;
}
// $dirpath = realpath(dirname(getcwd()));



?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <img src="../네이버이미지.jpeg" alt="">
    </body>
</html>