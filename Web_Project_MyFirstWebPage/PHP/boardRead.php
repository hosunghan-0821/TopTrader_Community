<?php 

    require_once('../lib/session.php'); 
    require_once('../lib/dbConnect.php');
    header("Cache-Control: no-cache");

    $db_connect = sqlCheck();
    $serialNum=$_GET['num'];

   
     //쿠키 관련 코드

     //쿠키가 아예 없을 경우  새로 쿠키를 만들고, 안에 읽은 게시글 정보 기입
    if(!isset($_COOKIE['PostView'])){
       
        $sql = "UPDATE PostTable SET Post_View = Post_View + 1 WHERE Post_Number='$serialNum'";
        mysqli_query($db_connect,$sql);
        setcookie("PostView", "$serialNum", time() + 86400, '/');
    }

    //존재하면, 현재 읽는 페이지가 쿠키 value에 있는지 확인하고, 있으면, 조회수 증가x
    else{
        $checkCookie=false;
        $viewCheck=$_COOKIE['PostView'];
        $viewCheckArray=explode("-",$viewCheck);
        for($i=0;$i<count($viewCheckArray);$i++){

            if($viewCheckArray[$i]==$serialNum){
                $checkCookie=true;
                break;
            }

        }

        //쿠키에 읽는 페이지의 정보가 있는지 확인! 없으면 추가
        if(!$checkCookie){
            $sql = "UPDATE PostTable SET Post_View = Post_View + 1 WHERE Post_Number='$serialNum'";
            mysqli_query($db_connect,$sql);
            $viewCheck=$_COOKIE['PostView']."-".$serialNum;
            setcookie("PostView", "$viewCheck", time() + 86400, '/');
        }
    }
  
  
    if(isset($_GET['scroll'])){
        $scroll=$_GET['scroll'];
    }
    else{
        $scroll="0";
    }

    //댓글 위한 쿼리문
    $sql="SELECT * from PostReplyTable where Reply_Post_Num=$serialNum ORDER BY Reply_Reg_date desc"; 

    if(isset($_SESSION['nickName'])){
        $nickName=$_SESSION['nickName'];
    }
    else{
        $nickName="_";
    }
   
    //게시글 읽기위한 쿼리문
    $select_query="SELECT * from PostTable where Post_Number=$serialNum and Post_Category='자유게시판' ";
  
    $select_result = mysqli_query($db_connect,$select_query);
    $Data = mysqli_fetch_array($select_result);
    $postHost="false";
    $name=$Data['Post_Writer'];
   

    if($name==null){
        $postHost="false";
        $name="탈퇴한 회원입니다.";
    }
    else{
        if($loginCheck=="true"){
        
            if($_SESSION['nickName']==$name){
                $postHost="true";
             }
        }
    }
    // query에서 가져온 정보들을 _이제 사용할 변수들 
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

                    <div class="write-data">
                        <div class="write-index">작성자 :</div>
                        <div class="write-content">
                            <?php echo "$name" ?>
                        </div>
                    </div>

                </div>
                <div class="write-date">

                    <div class="write-data">
                        <div class="write-index">
                            제목&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
                        <div class="write-content">
                            <?php echo "$title" ?></div>
                    </div>

                    <div class="write-data">
                        <div class="write-index">작성일 :</div>
                        <div class="write-content"><?php echo "$dateTime[0]" ?>
                        </div>

                    </div>
                    <div class="write-border"></div>
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
                        <?php echo $Data['Post_Like'] ?>
                    </div>
                    <div>조회수 :
                        <?php echo $Data['Post_View'] ?>
                    </div>
                    <div>댓글 :
                        <?php echo $Data['Post_Reply_Num']?>
                    </div>
                </div>

                <div class="comment-plus">

                    <form action="../lib/replyUpload.php" method="POST" id="replyForm">
                        <textarea
                            class="comment-textarea"
                            name="reply"
                            id="editor"
                            placeholder="저작권 등 다른 사람의 권리를 침해하거나 명예를 훼손하는 게시물은 이용약관 및 관련 법률에 의해 제재를 받을 수 있습니다. "></textarea>
                        <div class="comment-plus-button" onclick="replySubmit()">댓글추가</div>
                        <input type="hidden" name="postNum" value="<?php echo $serialNum; ?>">
                        <input id="scroll" type="hidden" name="scroll">
                    </form>

                </div>

                <div class="comment">

                    <?php 
                     $selectReply=mysqli_query($db_connect,$sql);
                     while($replyData = mysqli_fetch_array($selectReply))
                     {
                        $replyContent=$replyData['Reply_Content'];
                        $replyContentPrint = str_replace("\r\n", "</br>", $replyContent);
                        $replyContentPrintJS = str_replace("\r\n", "\\n", $replyContent);
                        if($replyData['Reply_Writer']==null){
                            $writer ="탈퇴한 회원";
                        }
                        else{
                            $writer=$replyData['Reply_Writer'];
                        }

                    ?>
                    <div class="reply-item">

                        <div class="comment-id">닉네임 :
                            <?php echo $writer; ?></div>
                        <div class="comment-time">
                            <div><?php echo $replyData['Reply_Reg_Update'] ?></div>
                            <div class="right-item">

                                <div class="comment-update" onclick="replyUpdateFunction( '<?php  echo $replyData['Reply_Writer']; ?>',  '<?php echo $replyData['no']; ?>')"> 수정 </div>
                                <div class="comment-delete" onclick="replyDeleteFunction('<?php  echo $replyData['Reply_Writer']; ?>', <?php echo $replyData['no']; ?>)">삭제</div>
                                <div id="comment-cancel<?php echo $replyData['no']?>"class="comment-cancel" >수정취소</div>
                                
                            </div>
                        </div>
                        <textarea id="comment-content<?php echo $replyData['no']?>" class="comment-content" disabled><?php echo  $replyContent; ?></textarea>
                        <div class="hidden-comment">
                            <textarea id="comment-content-update<?php echo $replyData['no']?>" class ="comment-content-update" name="replyUpdate" id="" cols="30" rows="5"></textarea>
                            <div id="comment-update-button<?php echo $replyData['no'] ?>" class="comment-update-button"  >댓글수정</div>
                        </div>
                      

                    </div>
                    <?php 
                     }
                    ?>
                </div>

            </div>

            <div class="bottom-function">

                <span
                    id="post-update"
                    class="bottom-function-update"
                    onclick="updateFunction()">
                    수정
                </span>
                <span
                    id="post-delete"
                    class="bottom-function-delete"
                    onclick="deleteFunction()">
                    삭제
                </span>

            </div>

        </div>

        <!-- 이 스크립트는 updateFunction & deleteFunction 관련한 스크립트 -->
        <script>
            
            let updateButton = document.getElementById('post-update');
            let deleteButton = document.getElementById('post-delete');
            if ('<?php echo $postHost ?>' == "false") {
                console.log("123");
                updateButton.style.display = "none";
                deleteButton.style.display = "none";
            }

            //게시글 수정
            function updateFunction() {

                let form = document.createElement('form');
                form.setAttribute('method', 'post');
                form.setAttribute('action', '../PHP/boardStandardWrite.php');

                var textField = document.createElement('input');
                textField.setAttribute('type', 'text');
                textField.setAttribute('name', 'Post_Num');
                textField.setAttribute('value', '<?php echo $serialNum; ?>');
                form.appendChild(textField);
                document
                    .body
                    .appendChild(form);
                form.submit();
            }

            //게시글 삭제
            function deleteFunction() {

                if (confirm("정말 삭제하시겠습니까?") == true) {
                    //여기서 post_delete 시킨다.
                    console.log("123");
                    fetch("../lib/deleteUpload.php", {
                        method: 'POST',
                        cache: 'no-cache',
                        headers: {
                            'Content-Type': 'application/json; charset=utf-8'
                        },
                        body: JSON.stringify({num: <?php echo $serialNum;?>})

                    })
                        .then((res) => res.text())
                        .then((data) => {
                            console.log(data);
                            switch (data) {
                                case 'true':
                                    {
                                        alert("글을 삭제하였습니다.")
                                        document.location.href = "../PHP/board.php";
                                        break;
                                    }
                                case 'false':
                                    {
                                        alert("글 삭제 실패하였습니다.")
                                        break;

                                    }
                            }
                        });

                } else {
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

            window.scrollTo(0, <?php echo $scroll; ?>);

            //댓글 달기 & 수정 관련 스크립트
            function replySubmit() {

                if(a==="false"){
                    alert("로그인 해주세요");
                    return false;
                }
                var scrollPosition = window.scrollY || document.documentElement.scrollTop;
     
                let scroll = document.getElementById('scroll');
                scroll.value = scrollPosition;
                let replyForm = document.getElementById('replyForm');
                replyForm.submit();
            }
            
            //댓글 수정하는 함수
            function replyUpdateFunction(replyWriter,replyNum){
              
                if(replyWriter==="<?php echo $nickName; ?>"){
                    let commentContentId='comment-content'+replyNum;
                    let commentUpdateId='comment-content-update'+replyNum;
                    let commentupdateButtonId='comment-update-button'+replyNum;
                    let commentCancelButtonId='comment-cancel'+replyNum;
                    
                    //댓글 일련번호를 활용하여 , 각 해당하는 댓글 동적으로 활용
                    let commentCancelButton=document.getElementById(commentCancelButtonId);
                    let commentNow = document.getElementById(commentContentId);
                    let commentUpdate= document.getElementById(commentUpdateId);
                    let commentUpdateButton =document.getElementById(commentupdateButtonId);


                    console.log(commentNow.innerText);
                    commentCancelButton.style.display="block";
                    commentNow.style.display="none";
                    commentUpdate.style.display="block";
                    //br태그를 \\n 으로 바꿔줘야함. innerText를

                    commentUpdate.value=commentNow.innerText;
                   
                    commentUpdateButton.style.display="flex";

                    // 수정취소시 reload 
                    commentCancelButton.addEventListener('click',function(){
                        location.reload();
                    });
                    //수정하는 로직
                    commentUpdateButton.addEventListener('click',function(){
                        if(confirm("댓글 정말 수정하시겠습니까?")== true){
                            fetch("../lib/updateReply.php",{

                            method: 'POST',
                            cache: 'no-cache',
                            headers: {
                            'Content-Type': 'application/json; charset=utf-8'
                            },
                            body: JSON.stringify({
                               
                                replyNum : replyNum,
                                replyContent:commentUpdate.value

                            })

                            })
                            .then((res) => res.text())
                            .then((data)=> {
                                if(data=='true'){
                                    location.reload();
                                }
                                else{
                                    alert("글 수정 실패하였습니다.");
                                }
                            });
                        }
                        else{
                            location.reload();
                        }

                    });
                }
                else{
                    alert("자신이 작성한 글만 수정 가능합니다.");
                }
            }
          
            //댓글 삭제하는 함수
            function replyDeleteFunction(replyWriter,replyNum){

                if(replyWriter==="<?php echo $nickName; ?>"){
                    //삭제하는  로직

                    if(confirm("댓글 정말 삭제하시겠습니까?")== true){
                        fetch("../lib/deleteReply.php",{

                            method: 'POST',
                            cache: 'no-cache',
                            headers: {
                            'Content-Type': 'application/json; charset=utf-8'
                        },
                        body: JSON.stringify({

                            postNum  : "<?php echo $serialNum; ?>",
                            replyNum : replyNum
                        
                        })


                        })
                        .then((res) => res.text())
                        .then((data)=> {
                            if(data=='true'){
                                location.reload();
                            }
                            else{
                                alert("글 삭제 실패하였습니다.");
                            }
                        });

                    }
                }
                else{
                    alert("자신이 작성한 글만 삭제 가능합니다.");
                }
            }
            
        </script>

    </body>

</html>