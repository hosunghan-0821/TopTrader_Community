<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/naverAPI.php';
   
    //db관련 추가코드
    $db_connect=sqlCheck();

    //세션관련 추가 코드
    if(!isset($_SESSION['nickName'])){
        $NickName="";
    }
    else{
        $NickName=$_SESSION['nickName'];
    }
    //get메소드로 키워드 받기
    if(isset($_GET['keyword'])){
        $searchKeyword=$_GET['keyword'];
        $dataItem=naverNewsResult($searchKeyword, 'sim', 15);
    }
    else{
        $dataItem= array();
    }
   
 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/stockSearch.css">
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
                <!-- <div class="nav-item">실시간 채팅</div> -->
                <div class="nav-item">
                    <a href="login.html" id="loginCheck">로그인</a>
                </div>
                <div class="nav-item">
                    <div id="mypage" class="mypage"></div>
                </div>
            </div>

        </div>

        <div class="wrapper">
            <!-- <div class="stock-header">

                <div class="stock-title">
                    종목정보

                </div>
                <div class="stock-register">
                    관싱종목 등록
                </div>

            </div>

            <div class="stock-content">

                <div class="stock-name">
                    <span>종목이름</span>
                    <span>ex) 삼성전자</span>

                </div>
                <div class="stock-price">
                    <span>10,000원</span>
                </div>
                <div class="stock-vol">
                    <span>+5%</span>
                </div>

            </div> -->

            <div class="stock-news">

                <div class="news-head">
                    <span>종목 뉴스정보</span>

                </div>
                <?php 
                    foreach($dataItem as $item){

                        $date=date_create($item->{'pubDate'});
                        $date=date_format($date,"Y/m/d H:i:s");

                    ?>

                <div class="news-item">

                    <div class="news"><a href="<?=$item->{'originallink'}; ?>"><?php echo $item->{'title'}; ?></a></div>
                    <div class="date"><?php echo $date; ?></div>

                </div>
                <?php 
                     }
                ?>

            </div>

        </div>


        <script>
            //로그인 체크 로직
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