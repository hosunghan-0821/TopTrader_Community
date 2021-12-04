<?php
    require_once('../lib/session.php');

    if(!isset($_SESSION['nickName'])){
        $NickName="";

    }
    else{
        $NickName=$_SESSION['nickName'];
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>주식 커뮤니티</title>
        <link rel="stylesheet" href="../CSS/myHtml.css">
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap"
            rel="stylesheet">
        <script>

          
        </script>
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

            <span class="search">
                <input type="text" class="search_box" placeholder="종목명 입력">
                <img src="../RESOURCE/img/search_image2.png" class="search-image">
            </span>

            <div class="nav-right-items">

                <div class="nav-item">
                    <a href="myHtml.php">홈</a>
                </div>
                <div class="nav-item">
                    <a href="board.php">게시판</a>
                </div>
                <!-- <div class="nav-item">실시간 채팅</div> -->
                <div class="nav-item">
                    <a href="login.html" id="loginCheck">로그인</a>
                </div>
                <div class="nav-item">
                    <div id="mypage" class="mypage"></div>
                </div>
            </div>

        </div>

        <div class="main" id="main">

            <div class="content">
                <div class="content-item">

                    <div class="economic-index">

                        <div class="kospi">
                            <div class="kospi-title">

                                <span>코스피</span>
                                <span>3,000.81</span>
                                <span>+1.28%
                                </span>

                            </div>
                            <div class="kospi-chart"></div>
                        </div>
                        <div class="kosdaq">
                            <div class="kosdaq-title">

                                <span>
                                    코스닥</span>
                                <span>
                                    1,030.34</span>
                                <span>
                                    -1.11%
                                </span>

                            </div>
                            <div class="kosdaq-chart"></div>

                        </div>
                    </div>
                </div>

                <div class="change-mode">

                    <div class="best-news">

                        <div class="best-news-title">
                            실시간 핵심 뉴스
                        </div>

                        <div class="news-content">

                            <ol>뉴스1</ol>
                            <ol>뉴스2</ol>
                            <ol>뉴스3</ol>
                            <ol>뉴스4</ol>
                            <ol>뉴스5</ol>

                        </div>

                    </div>

                    <div class="best-post">

                        <div class="best-post-title">
                            인기 게시글
                        </div>

                        <div class="post-content">
                            <ol>글1</ol>
                            <ol>글2</ol>
                            <ol>글3</ol>
                        </div>
                    </div>

                </div>

            </div>
            <div class="sidebar">
                <div class="sidebar-title">
                    등락률 상위
                </div>

            </div>
            <!-- <div class="information"> <div class="information-item"> <div
            class="information-item-title"> 핵심뉴스 <div class="image"> <img src="./news.jpg"
            alt="" style="max-width: 90%; height: auto;"> </div> </div> </div> <div
            class="information-item"> <div class="information-item-title"> 매매일지 <div
            class="image"> <img src="./RESOURCE/record.jpg" alt="" style="max-width: 90%;
            height: auto;"> </div> </div> </div> <div class="information-item"> <div
            class="information-item-title"> 자유게시판 <div class="image"> <img
            src="./notice.jpg" alt="" style="max-width: 90%; height: auto;"> </div> </div>
            </div> </div> -->

        </div>

        <footer>footer</footer>

        <script>

            var a = "<?php echo  $loginCheck; ?>";

            if (a === "true") {
                //console.log("여기 들어왔습니다.");
                document
                    .getElementById("loginCheck")
                    .innerText = "로그아웃";
                document
                    .getElementById("loginCheck")
                    .href = "../lib/logout.php";

                let mypage =document.getElementById("mypage");
                mypage.innerText="내 정보";
                mypage.addEventListener('click',function(e){

                    let form = document.createElement('form');
                    form.setAttribute('method', 'post');
                    form.setAttribute('action', '../PHP/mypage.php');

                    let inputField= document.createElement('input');
                    inputField.setAttribute('type', 'text');
                    inputField.setAttribute('name', 'nickName');
                    inputField.setAttribute('value', '<?php  echo $NickName; ?>');
                    form.appendChild(inputField);
                    document.body.appendChild(form);
                    form.submit();
                });
            }


            //쿠키 가져오는 스크립트.
            function getCookie(name)
            {
                //문서에 존재하는 쿠키들 다 가져옴 == document.cookie; ex) phpid=123;cookiename=hosung; 
                var cookie= document.cookie;
               
                if(document.cookie !=""){
                    var cookie_array=cookie.split(";");
                    for(var i in cookie_array){
                        console.log(cookie_array[i]);
                    }
                    for(var index in cookie_array){
                        var cookie_name = cookie_array[index].split("=");
                        if(cookie_name[0]=="hosung"){
                            console.log("여기 들어왔어요");
                            return cookie_name[1];
                        }
                    }
                   
                }
                return ;

            }

            function openPopup(url){
                var cookieCheck= getCookie("hosung");
                console.log()
                if(cookieCheck != "N") {
                    window.open(url, '', 'width=600,height=400,left=0,top=0')
                } 
            }

    
            openPopup('popup.html');

        </script>
    </body>
</html>