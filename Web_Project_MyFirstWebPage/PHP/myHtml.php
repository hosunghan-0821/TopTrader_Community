<?php

    // 크롤링을 위한 include
    //데이터베이스, 세션 접근을 위한 require
    include '/home/hosung/apache/Web_Project_MyFirstWebPage/lib/simple_html_dom.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
  
    if(!isset($_SESSION['nickName'])){
        $NickName="";
    }
    else{
        $NickName=$_SESSION['nickName'];
    }
    
     //인기 게시글 관련 데이터 뽑아오기 조회수 순서로 
     $db_connect=sqlCheck();
     $sql="SELECT * FROM PostTable ORDER BY Post_View DESC limit 0,5";

    // 크롤링 관련해서 내가 원하는 정보만 뽑아와서 각 변수에 담기

     //$chart_number_1= iconv("EUC-KR","UTF-8",  $chart_number_1); 글씨 깨질 때 사용
    $data= file_get_html("https://news.naver.com/main/main.naver?mode=LSD&mid=shm&sid1=101");
    $chart = file_get_html("https://finance.naver.com/");
    $chart_number=$chart->find("span.num_quot>span");


    $chart_data = $chart->find("div.chart_area");
    $kospiImg = $chart_data[0]->find("img",0)->src;
    $kosdaqImg= $chart_data[1]->find("img",0)->src;
  

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

                <form id="searchForm" action="../PHP/stockSearch.php" method="get">
                <input id="searchKeyword" name="keyword"type="text" class="search_box" placeholder="종목 뉴스 검색">
                </form>
                <img src="../RESOURCE/img/search_image2.png" class="search-image" onclick="stockSearch()">
            </span>

            <div class="nav-right-items">

                <div class="nav-item">
                    <a href="myHtml.php">홈</a>
                </div>
                <div class="nav-item">
                    <a href="board.php">게시판</a>
                </div>
                <div id="chat" class="nav-item">실시간 채팅</div>
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
                                <span id="kospi-price"><?php echo $chart_number[0]; ?></span>
                                <span id="kospi-volatility"><?php echo $chart_number[2]; ?></span>

                            </div>
                            <img class="kospi-chart" src="<?= $kospiImg ?>" alt="../RESOURCE/img/HTTP 웹메소드 특징들표.png">
                           
                        </div>
                        <div class="kosdaq">
                            <div class="kosdaq-title">

                                <span>코스닥</span>
                                <span id="kosdaq-price"><?php echo $chart_number[4]; ?></span>
                                <span id="kosdaq-volatility"><?php echo $chart_number[6]; ?></span>

                            </div>

                           
                            <img class="kosdaq-chart" src="<?= $kosdaqImg ?>" alt="../RESOURCE/img/HTTP 웹메소드 특징들표.png">
                           

                        </div>
                    </div>
                </div>

                <div class="change-mode">

                    <div class="best-news">

                        <div class="best-news-title">
                           경제 핵심 뉴스
                        </div>

                        <div class="news-content">

                          <?php 
                            $newsArray= $data->find("div.cluster_text>a");
                            $article= $data->find("div.cluster_text_press");
                                for($i=0; $i<8; $i++){
                          ?>
                          <div class="news-item">
                            <ul class="news-headline"> <?php echo $i+1 .".  ";  echo "$newsArray[$i]"; ?> </ul>
                            <ul class="article-head"><?php echo "   " .$article[$i] ?></ul>
                          </div>
                        

                          <?php 
                               }
                          ?>
                        </div>

                    </div>

                    <div class="best-post">

                        <div class="best-post-title">
                            인기 게시글
                        </div>

                        <div class="post-content">
                            <?php 

                            $postSelectResult=mysqli_query($db_connect,$sql);
                           while($bestPost=mysqli_fetch_array( $postSelectResult)){

                          
                            $title=$bestPost['Post_Title'];
                            $viewPost=$bestPost['Post_View'];
                            $replyPost=$bestPost['Post_Reply_Num'];
                            $postNumber=$bestPost['Post_Number'];
                
                            ?>
                            <div class="best-post-item">
                                <div><a href="boardRead.php?num=<?php echo $postNumber?>"><?= $title."[".$replyPost."]" ?> </a></div>
                                <div class="best-post-view"><?= "조회수 ".$viewPost?> </div>
                            </div>
                            <?php 
                             }
                            ?>
                        
                        </div>
                    </div>

                </div>

            </div>
            <!-- <div class="sidebar">
                <div class="sidebar-title">
                    등락률 상위
                </div>

            </div> -->
        </div>

        <footer>footer</footer>

        <script>

            // 채팅 팝업창 만들기

            const chat = document.getElementById("chat");

            chat.addEventListener('click', function(e){
                let userCheck="true";
                if("<?php echo $NickName?>"!=""){

                    fetch("http://192.168.163.131:3000/test", {
                        method: 'POST',
                        cache: 'no-cache',
                        headers: {
                            'Content-Type': 'application/json; charset=utf-8'
                        },
                    })
                        .then((res) => res.text())
                        .then((data) => {
                           console.log(data);
                           const obj =JSON.parse(data);
                        //    console.log(obj);
                       
                        // obj.chatUser[0]
                        for(let i=0; i<obj.chatUser.length;i++){
                            console.log(obj.chatUser[i]);
                            if(obj.chatUser[i]=='<?=$NickName?>'){
                                console.log("확인");
                                userCheck="false";
                            }
                            
                        }
                        if(userCheck==="true"){
                            alert("실시간채팅 접속허용");
                            window.open("../ChatExample/chat_client.php", '', 'width=600,height=1000,left=0,top=0');
                        }
                        else{
                            alert("실시간채팅 접속불가 같은 아이디로 사용중");
                        }
                           
                        //   for(var i in data){
                        //       console.log(data[i]['chatUser']);
                        //   }
                          
                        //    console.log(data."chatUser".[0]);
                        //    for(var i in data){
                        //        console.log(i);
                        //    }
                        //    foreach(key as data){
                        //        console.log(key);
                        //    }
                        });
               
                   
                }
                else{
                    alert("로그인 없이는 실시간 채팅 기능 사용 불가능 합니다");
                    location.href="login.html";
                }
               
            });


            //로그인 관련 스크립트
            var a = "<?php echo  $loginCheck; ?>";

            if (a === "true") {
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


            //쿠키관련스크립트들

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
                        if(cookie_name[0]==name){
                            console.log("여기 들어왔어요");
                            return cookie_name[1];
                        }
                    }
                   
                }
                return "false";
            }

            function openPopup(url){
                var cookieCheck= getCookie("hosung");
                console.log()
                if(cookieCheck != "N") {
                    window.open(url, '', 'width=600,height=400,left=0,top=0')
                } 
            }
            openPopup('popup.html');

            //상승 하락에 따른 글씨 색깔 바꿔주기.
            let kospiPrice= document.getElementById("kospi-price").firstChild;
            let kospiVol= document.getElementById("kospi-volatility").firstChild;
            let kosdaqPrice= document.getElementById("kosdaq-price").firstChild;
            let kosdaqVol= document.getElementById("kosdaq-volatility").firstChild;
            let kospiCheck=kospiVol.innerText.substring(0,1);
            let kosdaqCheck=kosdaqVol.innerText.substring(0,1);

            if( kospiCheck== '+'){
                kospiPrice.style.color="red";
                kospiVol.style.color="red";
            }
            else{
                kospiPrice.style.color="blue";
                kospiVol.style.color="blue";
            }
            
            if( kosdaqCheck== '+'){
               
               kosdaqPrice.style.color="red";
               kosdaqVol.style.color="red";
           }
           else{
               kosdaqPrice.style.color="blue";
               kosdaqVol.style.color="blue";
           }

           function stockSearch(){
               let searchForm=document.getElementById("searchForm");
               let searchKeyword=document.getElementById("searchKeyword");

               if(searchKeyword.value!=""){
                   searchForm.submit();
               }
               else{
                   alert("검색어를 입력하세요");
                   searchKeyword.focus();
               }
           }

        </script>

    </body>
</html>