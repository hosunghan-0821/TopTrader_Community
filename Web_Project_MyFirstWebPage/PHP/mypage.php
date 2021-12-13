<?php
     
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    header("Cache-Control: no-cache");
    $db_connect=sqlCheck();
    $nickName=$_SESSION['nickName'];
    $ID=$_SESSION['ID'];

    

    //회원글 paging 하기위해서 짜는 로직
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }

    //회원 게시글을 가져오기 위해 사용하는 sql 문
    $postSql="SELECT * FROM PostTable Where(Post_Writer='$nickName')";
    $postSelectResult=mysqli_query($db_connect,$postSql);
    $totalPostNumber = mysqli_num_rows($postSelectResult);

    //총 회원글의 갯수를 구한후, paging 로직을 위한 변수 설정
    $list=5;
    $blockCnt=5;
    $blockNum= ceil($page/$blockCnt);
    $blockStart= (($blockNum-1)*$blockCnt)+1;
    $blockEnd=$blockStart+$blockCnt-1;
    $totalPage =ceil($totalPostNumber/$list);
    if($blockEnd>$totalPage){
        $blockEnd=$totalPage;
    }
    $pageStart = ($page-1)*$list;

    //로직에 맞춰서 해당 게시글 가져오는 sql 문
    $postSql="SELECT * FROM PostTable WHERE(Post_Writer='$nickName') ORDER BY Post_date desc LIMIT $pageStart,$list " ;
    $postSelectResult=mysqli_query($db_connect,$postSql);

    //회원정보 랑 join 해서 게시글 정보까지 한번에 가져오는 sql 문
    //이 sql 문은 글이 하나도 없을 때 회원정보를 못가져오는 버그가 존재한다..
    //$sql = "SELECT * FROM CommunityMember inner join PostTable on CommunityMember.Member_NickName=PostTable.Post_Writer WHERE(Member_ID = '$ID')";
    
    //회원정보를 가져오기 위해 사용하는 sql 문
    $sql = "SELECT * FROM CommunityMember WHERE(Member_ID = '$ID')";
    $select_result=mysqli_query($db_connect,$sql);
    $Data=mysqli_fetch_array($select_result);

   
   


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS//mypage.css">
        <title>Document</title>
    </head>
    <body>
        <div class="nav">

            <div class="nav-item">

            
                <span class="main-title">
                    <a href="../PHP/myHtml.php">
                    Top Trader<br>
                    Community </a>
                </span>
                   
               
                <span class="main-title">
                   
                </span>

            </div>

        </div>
        <div class="main">

            <div class="wrapper">

                <div class="member-wrapper">

                    <div class="member-info">
                        회원정보
                    </div>
                    <div class="member-info-content">

                        <div class="member-data">

                            <span class="data-text"> 닉네임 :
                            </span>
                            <input type="text" id="member-nickname">
                        </div>
                        <div class="member-data">
                            <span class="data-text"> 이메일 :
                            </span>
                            <span id="member-email">
                                <?php echo $Data['Member_Email']; ?>
                            </span>
                        </div>
                        <div class="member-data">
                            <span class="data-text"> 아이디 :
                            </span>
                            <span id="member-id">
                                <?php echo $Data['Member_ID']; ?></span>
                        </div>
                    </div>
                    <input type="password" id="changeInput" placeholder="비밀번호를 입력하세요">
                    <span id="outButton">회원탈퇴 확인</span>
                    <div class="member-out">
                        <span id="passwordChange">비밀번호 변경</span>
                        <span id="nickNameChange">닉네임 변경</span>
                        <span id="memberOut">회원탈퇴</span>
                    </div>
                </div>

                <div class="member-wrapper">
                    <div class="member-info">
                        회원 게시글
                    </div>

                    <div class="post-head">
                        <div class="post-head-title">제목</div>
                        <div class="post-head-date">게시글 날짜</div>
                        
                    </div>

                   
                        <?php 
                         while($Post_Data = mysqli_fetch_array($postSelectResult))
                         {
                             $title=$Post_Data['Post_Title'];
                             $post_date=$Post_Data['Post_Date'];
                             $date=explode(" ",$post_date);
                             $post_num=$Post_Data['Post_Number'];
                             //$date[0] : 날짜 
                             //$date[1] : 시간
                        ?>
                        <div class="post-content">

                        <div class="post-content-title"><a href="../PHP/boardRead.php?num=<?php echo $post_num; ?>"><?php echo $title; ?></a></div>
                        <div class="post-content-date"><?php echo $date[0]; ?></div>
                        </div>
                        <?php
                         }
                        ?>

                    <div class="paging">
                        <?php 
                        if($totalPostNumber!=0){
                            if($page>1){
                                $pre =$page -1;
                            }
                            else{
                                $pre=1;
                            }
                            echo"<a href='mypage.php?page=1' class='paging-order'>처음</a>";
                            echo"<a href='mypage.php?page=$pre'  class='paging-order'>이전</a>";

                            for($i=$blockStart;$i<=$blockEnd;$i++){
                                if($i==$page){
                                    echo "<b> $i </b>";
                                }
                                else{
                                    echo"<a href='mypage.php?page=$i' class='paging-num'>$i</a>";
                                }
                            }
                            if($page<$totalPage){
                                $next=$page+1;
                            }
                            else{
                                $next=$totalPage;
                            }
                            echo "<a href='mypage.php?page=$next'  class='paging-order'>다음</a>";
                            echo "<a href='mypage.php?page=$totalPage'  class='paging-order'>   마지막</a>";

                        }
                        
                        ?>


                    </div>

                    
                </div>

        </div>
    </div>

    <script>
        let passwordChange=document.getElementById('passwordChange');
        let memberOut=document.getElementById('memberOut');
        let nickNameChange = document.getElementById('nickNameChange');
        let changeInput = document.getElementById('changeInput');
        let nickName = document.getElementById('member-nickname');
        let outButton = document.getElementById('outButton');
        nickName.value = '<?php echo $Data['Member_NickName']; ?>';

        passwordChange.addEventListener('click',function(e){
            console.log(123);
            let check= confirm("비밀번호 변경 하시겠습니까?");
            if(check){
                location.href="passwordChange.html";
            }
        });


        memberOut.addEventListener('click',function(e){
            let check = confirm("정말 회원탈퇴 하시겠습니까?");
            if(check){
               changeInput.style.display="block";
               outButton.style.display="inline";
               changeInput.focus();
            }

        });
        outButton.addEventListener('click',function(e){

            let data ={
                id : '<?php echo $Data['Member_ID']; ?>',
                check: "Member_Out"
            }
            if(changeInput.value=='<?php echo $Data['Member_Password'] ?>'){
                fetch("../lib/memberInfoChange.php",{

                    method: 'POST',
                    cache: 'no-cache',
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    },
                    body: JSON.stringify(data)
                })
                .then((res)=> res.text())
                .then((data)=> {
                    if(data=='true'){
                        alert('회원탈퇴 하셨습니다.')
                        document.location.href="../PHP/myHtml.php";
                    }
                    else{
                        alert('회원탈퇴 실패');
                    }
                });
            }
            else{
                alert("비밀번호가 다릅니다 ");
            }
        });

        //여기는 닉네임 바꾸는 이벤트
        nickNameChange.addEventListener('click', function (e) {
            nickName.focus();

            if (nickName.value === '<?php echo $Data['Member_NickName']; ?>') {
                alert('기존 닉네임과 동일합니다 ');
                return false;
            } else {
                let obj = {
                    id: nickName.value,
                    check: "Member_NickName"
                }
                fetch("../lib/idVerfication.php", {
                    method: 'POST',
                    cache: 'no-cache',
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    },
                    body: JSON.stringify(obj)
                })
                    .then((res) => res.text())
                    .then((data) => {

                        if (data == 'true') {

                            let check = confirm("닉변 할거? 중복아님");
                            if (check) {
                                fetch("../lib/memberInfoChange.php", {
                                    method: 'POST',
                                    cache: 'no-cache',
                                    headers: {
                                        'Content-Type': 'application/json; charset=utf-8'
                                    },
                                    body: JSON.stringify({nickName : nickName.value, check:'Member_NickName_Change' })
                                })
                                    .then((res) => res.text())
                                    .then((data) => {
                                        console.log(data);
                                        switch (data) {
                                            case 'true':
                                                {
                                                  alert("닉네임 변경되었습니다.");
                                                  location.reload();
                                                  break;
                                            
                                                }
                                            case 'false':
                                                {
                                                    alert("닉네임 변경실패.");
                                                    break;
                                                }
                                        }
                                    });

                            }

                        } else {
                            alert("닉네임 중복입니다.");
                        }

                    });

            }

        });


    </script>
</body>

</html>