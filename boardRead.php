<?php 

$serialNum=$_GET['num'];

$db_connect = mysqli_connect("192.168.163.128","hosung","ghtjd114","hosungDB");
$select_query="SELECT * from testBoardTable where seq=$serialNum";
$select_result = mysqli_query($db_connect,$select_query);
$Data = mysqli_fetch_array($select_result);

$name=$Data['name'];
$date=$Data['date'];
$imageRoute=$Data['imageRoute'];
$content=$Data['content'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="./CSS/boardRead.css">
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap"
            rel="stylesheet">

    </head>
    <body>

        <div class="nav">

            <div class="nav-left-items">

                <div class="nav-title">
                    Top Trader
                    <br>Community
                </div>

            </div>

            <div class="nav-right-items">

                <div class="nav-item">
                    <a href="./myHtml.html">홈</a>
                </div>
                <div class="nav-item">
                    <a href="./board.html">게시판</a>
                </div>
                <!-- <div class="nav-item">실시간 채팅</div> -->
                <div class="nav-item">
                    <a href="login.html">로그인</a>
                </div>
            </div>
        </div>

        <div class="main-block">

            <div class="main-title">

                <div class="main-writer">
                    작성자 :
                    <?php echo "$name" ?>
                </div>
                <div class="write-date">
                    작성일 :
                    <?php echo "$date" ?>
                </div>
            </div>

            <div class="main-content">
                <div class="content-image">

                    <img
                        src="<?php echo "$imageRoute" ?>"
                        style="background-size: contain;"
                        alt="./img/HTTP 웹메소드 특징들표.png">
                </div>

                <div class="content">
                    <?php echo "$content"?>
                </div>

            </div>

            <div class="bottom-comment">

                <div class="comment-head">
                    <div >좋아요 :
                    </div>
                    <div >조회수 :
                    </div>
                    <div>댓글 :
                    </div>
                </div>

                <div class="comment">
                    <div class="id">
                        id
                    </div>
                    <div class="comment-content">
                        댓글 내용
                    </div>
                </div>

            </div>

        </div>

    </body>
</html>