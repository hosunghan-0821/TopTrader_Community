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
$title=$Data['Post_Title'];

$dateTime=explode(" ",$date);
$nowDate= date("Y-m-d");
// echo $dateTime[0]."<br/>";
// echo $dateTime[1];

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../CSS/boardRead.css">
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
                    <span>
                        제목 :
                        <?php echo "$title" ?></span>
                    <span class="write-date-date">
                        작성일 :
                        <?php echo "$dateTime[0]" ?></span>

                </div>
            </div>

            <div class="main-content">

                <div class="content-image" id="image">
                    <img id="content-image" src="<?php echo "$imageRoute" ?>" alt="">
                </div>

                <div class="content">
                    <?php echo nl2br($content)?>
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

            <div class="bottom-function">

                <span id="post-update" class="bottom-function-update" onclick="updateFunction()">
                    수정
                </span>
                <span id="post-delete" class="bottom-function-delete" onclick="deleteFunction()">
                    삭제
                </span>

            </div>

        </div>

        <!-- 이 스크립트는 updateFunction & deleteFunction 관련한 스크립트 -->
        <script>
            
            function updateFunction(){
                
                let form=document.createElement('form');
                form.setAttribute('method','post');
                form.setAttribute('action','../PHP/boardStandardWrite.php');
               
                var textField =document.createElement('input');
                textField.setAttribute('type','text');
                textField.setAttribute('name','Post_Num');
                textField.setAttribute('value','<?php echo $serialNum; ?>');
                form.appendChild(textField);
                document.body.appendChild(form);
                form.submit();
            }
            function deleteFunction(){

                if(confirm("정말 삭제하시겠습니까?")==true){
                    //여기서 post_delete 시킨다.
                    console.log("123");
                    fetch("../lib/deleteUpload.php",{
                        method: 'POST',
                        cache: 'no-cache',
                        headers :{
                            'Content-Type': 'application/json; charset=utf-8'
                        },
                        body : JSON.stringify({num : <?php echo $serialNum;?>})

                    })
                    .then((res)=>res.text())
                    .then((data)=>{
                        console.log(data);
                        switch(data){
                            case 'true':
                            {
                                alert("글을 삭제하였습니다.")
                                document.location.href="../PHP/board.php";
                                break;
                            }
                            case 'false':
                            {
                                alert("글 삭제 실패하였습니다.")
                                break;
                                
                            }
                        }
                    });

                }
                else{
                    return false;
                }

            }

        </script>

          <!-- 이 스크립트는 로그인 관련, php 코드를 써야해서.. 분리 안됨... -->
        <script>

            //로그인 세션을 활용하여서, 상단 네비게이션바 로그인-> 로그아웃으로 텍스트 변경하는 코드
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


            //불러온 글의 이미지가 없을 경우 이미지 영역을 style.display = "none" 함으로써 글의 위치가 적당하게 나오게하는 코드
            if ("<?php echo $imageRoute; ?>" == "") {
                let image = document.getElementById("image");
                image.style.display = "none";
            }
        </script>

    </body>

</html>