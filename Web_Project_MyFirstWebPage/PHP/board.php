<?php
session_start();
$loginCheck;
if(!isset($_SESSION['is_login'])){
    $loginCheck="false";
}
else{
    $loginCheck="true";
}
require_once('../lib/dbConnect.php');
$db_connect=sqlCheck();

$select_query="SELECT 
Post_Writer, 
Post_Number,
Post_Title,
Post_Like,
Post_View,
Post_Date  
from PostTable";
$select_result=mysqli_query($db_connect,$select_query);
 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/border.css">
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap"
            rel="stylesheet">
        <title>Document</title>
    </head>
    <body>

        <div class="nav">

            <div class="nav-left-items">

                <div class="nav-title">
                    
                    <a href="myHtml.php">
                        Top Trader
                        <br>Community
                    </a>

                </div>

            </div>

            <div class="nav-right-items">

                <div class="nav-item">
                    <a href="./myHtml.php">홈</a>
                </div>
                <div class="nav-item">
                    <a href="./board.php">게시판</a>
                </div>
                <!-- <div class="nav-item">실시간 채팅</div> -->
                <div class="nav-item">
                    <a href="login.html" id="loginCheck">로그인</a>
                </div>
            </div>

        </div>

        <div class="board-list-wrap">
            <div class="board-list">

                <div class="board-list-head">
                    <div class="num">번호</div>
                    <div class="title">제목</div>
                    <div class="writer">글쓴이</div>
                    <div class="date">작성일</div>
                    <div class="view">조회</div>

                </div>

                <div class="board-list-body" id="postBody">

                    <?php
                    while($Data = mysqli_fetch_array($select_result))
                    {

                        $Post_Writer=$Data['Post_Writer'];
                        $Post_Number=$Data['Post_Number'];
                        $Post_Title=$Data['Post_Title'];
                        //$Post_Content=$Data['Post_Content'];
                        $Post_Date = $Data['Post_Date'];
                        $Post_View=$Data['Post_View']

                
                     ?>

                    <div class="item">

                        <div class="num" id="num"><?= $Post_Number; ?></div>
                        <div class="title">
                            <a href="boardRead.php?num=<?php echo $Post_Number?>"><?php echo $Post_Title; ?></a>
                        </div>
                        <div class="writer"><?php echo $Post_Writer; ?></div>
                        <div class="date"><?php echo $Post_Date; ?></div>
                        <div class="view"><?php echo $Post_View; ?></div>

                    </div>

                    <?php 
                    }
                    ?>
                </div>

            </div>

            <div class="paging">
                <a href="#" class="first">
                    처음 페이지
                </a>
                <a href="#" class="previous">
                    이전 페이지
                </a>
                <a href="#" class="num">
                    1
                </a>
                <a href="#" class="num">
                    2
                </a>
                <a href="#" class="num">
                    3
                </a>
                <a href="#" class="next">
                    다음 페이지
                </a>
                <a href="#" class="last">
                    마지막 페이지
                </a>
                <div class="write" onclick="writeFunction()">
                    글쓰기
                </div>
            </div>
        </div>

        <script>

            var a = "<?php echo  $loginCheck; ?>";

            console.log(a);

            if (a === "true") {
                console.log("여기 들어왔습니다.");

                document
                    .getElementById("loginCheck")
                    .innerText = "로그아웃";
                document
                    .getElementById("loginCheck")
                    .href = "../lib/logout.php";
                // idCheck.innerHTML = "로그아웃";
            }

            function writeFunction() {
               document.location.href='boardStandardWrite.html';
            }
            function readFunction() {

                // const request = new XMLHttpRequest(); var name = document
                // .getElementById("num")     .innerText; console.log(name);
                // request.onreadystatechange = function () {     if (request.readyState == 4 &&
                // request.status == 200) {         window.location.href = request.responseURL;
                // } } const myurl = './boardRead.php?num=' + name; request.open('GET', myurl,
                // true); request.send();

            }
        </script>

    </body>
</html>