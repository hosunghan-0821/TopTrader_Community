<?php
require_once('../lib/session.php');

//update 로 들어왔을 경우 글 번호를 갖고, 수정하기 위해 데이터 불러오기.

        if(isset($_POST['Post_Num'])){
            $updateCheck="true";
            $serialNum=$_POST['Post_Num'];
            require_once('../lib/dbConnect.php');
            $db_connect = sqlCheck();
            
            $select_query="SELECT * from PostTable where Post_Number=$serialNum and Post_Category='자유게시판' ";
            $select_result = mysqli_query($db_connect,$select_query);
            $Data = mysqli_fetch_array($select_result);

            $name=$Data['Post_Writer'];
            $date=$Data['Post_Date'];
            $imageRoute=$Data['Post_Image_Route'];
            $imageRouteArray=explode("-",$imageRoute);

            $content=$Data['Post_Content'];
            $title=$Data['Post_Title'];

            //자바스크립트로 textarea에 찍어주기 위해서 개행문자 "\n" 로바꿔주는 함수
            $contentPrint = str_replace("\r\n", "\\n", $content);
        }
        else{
            $serialNum=null;
            $content="";
            $updateCheck="false";
            $imageRoute=null;
            $title="";
            $contentPrint="";

        }


?>
 


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS//boardStandardWrite.css">
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

        <div class="main">
            <div class="main-title">
                <span class="board-category" id="board-category">
                    자유게시판 글쓰기
                </span>

                <span class="write-content" onclick="postContent()" id="write-content">
                    글 등록
                </span>
            </div>
            <form
                id="postForm"
                action="../lib/postUpload.php"
                method="post"
                enctype="multipart/form-data">
                <div >
                    <input
                        type="text"
                        id="content-title"
                        name="title"
                        class="content-title"
                        placeholder="제목을 입력해 주세요">
                </div>
                <div class="notice">
                    ***공지사항***
                </div>
                <div class="content">
                    <textarea name="textarea" id="editor" cols="30" rows="10"></textarea>
                </div>
                <img src="" alt="" id="image-preview" width=150px height=150px>
                
                <span> &nbsp;&nbsp;&nbsp;&nbsp;</span>
                <input id="img-selector" name="imgFile[]" type="file" accept="image/*" multiple/>
               
                <div>
                <span id="image-text">상위 이미지 외 <?php echo count($imageRouteArray)-2; echo "개";?></span>
                <span id="img-reset" class="img-reset">이미지 초기화</span>
                <span> (이미지 초기화시 복구 불가능 합니다.)</span>
                </div>
            </form>

        </div>

        <script>
            let imageText = document.getElementById('image-text');
            let imageClear=false;
            let postForm = document.getElementById('postForm');
            let files=document.getElementById("img-selector");
            let checkUpdate="<?php echo $updateCheck; ?>";
            let imgReset=document.getElementById("img-reset");
            const previewImage = document.getElementById("image-preview");

            imgReset.addEventListener('click', function(e){
                
                files.value="";
                previewImage.src="";
                imageClear=true;

            });
            //로그인 세션을 활용하여서, 상단 네비게이션바 로그인-> 로그아웃으로 텍스트 변경하는 코드
            var a = "<?php echo  $loginCheck; ?>";
            if (a === "true") {
                document
                    .getElementById("loginCheck")
                    .innerText = "로그아웃";
                document
                    .getElementById("loginCheck")
                    .href = "../lib/logout.php";
                // idCheck.innerHTML = "로그아웃";
            }
            //글 포스팅 하는부분
            function postContent() {

                let contentTitle = document.getElementById('content-title');
                if (contentTitle.value == "") {
                    alert("제목을 입력하세요");
                    contentTitle.focus();
                } else {
                   
                    if(checkUpdate==="true"){
                        let appendInput=document.createElement('input');
                        appendInput.setAttribute('type','text');
                        appendInput.setAttribute('name','update');
                        appendInput.setAttribute('value','true');

                        let appendInput2=document.createElement('input');
                        appendInput2.setAttribute('type','number');
                        appendInput2.setAttribute('name','Post_Num');
                        appendInput2.setAttribute('value',<?php echo $serialNum; ?>);
                        postForm.appendChild(appendInput);
                        postForm.appendChild(appendInput2);
                    }
                    if(imageClear===true){
                        let appendInput=document.createElement('input');
                        appendInput.setAttribute('type','text');
                        appendInput.setAttribute('name','imageClear');
                        appendInput.setAttribute('value','true');
                        postForm.appendChild(appendInput);
                    }
                    postForm.submit();
                }

            }

            //글 수정 할 때 내용 불러와서 동적으로 띄워주는 부분
            
            if(checkUpdate === "true"){

                let postText=document.getElementById("write-content");
                let textarea=document.getElementById("editor");
                let title=document.getElementById("content-title");
                let boardTitle=document.getElementById("board-category");

                postText.innerText="글 수정";
                boardTitle.innerText="자유게시판 글 수정"
                previewImage.src="<?php echo $imageRouteArray[0]; ?>";
                textarea.value="<?php echo $contentPrint;?>";
                title.value="<?php echo $title; ?>";

            }

            //수정안할 때,
            else{
                
            }
            //이미지 선택할 떄 동적으로 이미지 띄어주는 곳
            const imageSelector = document.getElementById('img-selector');
            imageSelector.addEventListener('change',function(e){
                
                const files =e.target.files;
                if(files){
                    insertImage(files[0]);
                }
            });

            function insertImage(file){

                const reader = new FileReader();
                reader.addEventListener('load', function (e) {

                    previewImage.src=e.target.result;
                    imageClear=false;
                    imageText.style.visibility="hidden";

                    //document.execCommand('insertImage',false,"../RESOURCE/img/abcd.png");
                });
                reader.readAsDataURL(file);
            }

        </script>

    </body>
</html>