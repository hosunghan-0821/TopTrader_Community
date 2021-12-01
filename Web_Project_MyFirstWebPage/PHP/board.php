<?php


    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    header("Cache-Control: no-cache");
    $db_connect=sqlCheck();
    
    if(isset($_POST['search-category'])){
       $searchCategory=$_POST['search-category'];
       $searchText=$_POST['search-text'];
       if($searchCategory=="제목"){
           $select_query="SELECT * FROM PostTable WHERE Post_Title LIKE '%$searchText%' ORDER BY Post_date desc";
       }
       else if($searchCategory=="작성자"){
           $select_query="SELECT * FROM PostTable WHERE (Post_Writer='$searchText' ) ORDER BY Post_date desc";
       }
    }
    else{
        $select_query = "SELECT Post_Writer,Post_Number,Post_Title,Post_Like,Post_View,Post_Date from PostTable ORDER BY Post_date desc " ;
    }

    $select_result=mysqli_query($db_connect,$select_query);

//$num=mysqli_num_rows($select_result);
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

            <div class="board-list-category">
                <a href="../PHP/board.php">
                    자유게시판
                </a>

            </div>
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
                        $Post_View=$Data['Post_View'];
                        $dateTime=explode(" ", $Post_Date);
                        $nowDate= date("Y-m-d");
                        if($nowDate===$dateTime[0]){
                            $boardTime=$dateTime[1];
                        }
                        else{
                            $boardTime=$dateTime[0];
                        }
                        if($Post_Writer==null){
                            $Post_Writer="탈퇴한 회원.";
                        }
                
                     ?>

                    <div class="item">

                        <div class="num" id="num"><?= $Post_Number; ?></div>
                        <div class="title">
                            <a href="boardRead.php?num=<?php echo $Post_Number?>"><?php echo $Post_Title; ?></a>
                        </div>
                        <div class="writer"><?php echo $Post_Writer; ?></div>
                        <div class="date"><?php echo $boardTime; ?></div>
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

            <div class="bottom-content">
                <div class="bottom-content-item">
                    <div class="bottom-search-category">
                        <form action="../PHP/board.php" method="post" id="search-form">

                            <select
                                name="search-category"
                                id="search-category"
                                onchange="changePlaceholder()">
                                <option value="제목">제목</option>
                                <option value="작성자">작성자</option>
                            </select>
                        </div>
                        <div class="bottom-search">

                            <input
                                type="text"
                                name="search-text"
                                class="search-text"
                                id="search-text"
                                placeholder="제목 입력">
                        </form>

                    </div>
                    <div id="bottom-search-button" class="bottom-search-button">
                        검색
                    </div>
                </div>

            </div>

        </div>

        <script>

            //bottom search 관련 자바스크립트
            let searchCategory = document.getElementById("search-category");
            let searchText = document.getElementById("search-text");
            let searchButton = document.getElementById("bottom-search-button");
            let searchForm = document.getElementById("search-form");

            searchButton.addEventListener('click', function (e) {
                if (searchText.value == "") {
                    console.log("456")
                    searchText.focus()
                    return false;
                } else {
                    searchForm.submit();
                }
            })

            function changePlaceholder() {
                if (searchCategory.value == "제목") {
                    searchText.placeholder = "제목 입력"
                } else if (searchCategory.value == "작성자") {
                    searchText.placeholder = "작성자 입력"
                }
            }

            //로그인 관련 스크립트
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
               
                 document.location.href = 'boardStandardWrite.php';
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