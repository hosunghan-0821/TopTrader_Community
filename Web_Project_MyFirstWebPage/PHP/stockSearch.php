<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/naverAPI.php';
   
    $db_connect=sqlCheck();

    if(isset($_GET['keyword'])){
        $searchKeyword=$_GET['keyword'];
        $dataItem=naverNewsResult($searchKeyword, 'sim', 7);
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
                <input type="text" class="search_box" placeholder="종목명 입력">
                <img
                    src="../RESOURCE/img/search_image2.png"
                    class="search-image"
                    onclick="stockSearch()">
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
            <div class="stock-header">

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

            </div>

            <div class="stock-news">

                <div class="news-head">
                    <span>뉴스정보</span>

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

    </body>
</html>