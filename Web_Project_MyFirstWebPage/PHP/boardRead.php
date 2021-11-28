<?php 
require_once('../lib/session.php');
require_once('../lib/dbConnect.php');
$serialNum=$_GET['num'];

$db_connect = sqlCheck();

$select_query="SELECT * from PostTable where Post_Number=$serialNum and Post_Category='자유게시판' ";
$select_result = mysqli_query($db_connect,$select_query);
$Data = mysqli_fetch_array($select_result);

$name=$Data['Post_Writer'];
$date=$Data['Post_Date'];
$imageRoute=$Data['Post_Image_Route'];
$content=$Data['Post_Content'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/boardRead.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">

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

                <img src="<?php echo "$imageRoute" ?>" style="background-size: contain;" alt="">
            </div>

            <div class="content">
                <?php echo "$content"?>
            </div>

        </div>

        <div class="bottom-comment">

            <div class="comment-head">
                <div>좋아요 :
                </div>
                <div>조회수 :
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
    </script>

</body>

</html>