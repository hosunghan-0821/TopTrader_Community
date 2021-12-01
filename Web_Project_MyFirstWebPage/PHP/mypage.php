<?php
     
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    header("Cache-Control: no-cache");
    $db_connect=sqlCheck();
    $nickName=$_POST['nickName'];
    $ID=$_SESSION['ID'];

    //회원정보를 가져오기 위해 사용하는 sql 문
    // $sql = "SELECT * FROM CommunityMember WHERE(Member_ID = '$ID')";

    //회원정보 랑 join 해서 게시글 정보까지 한번에 가져오는 sql 문
    $sql = "SELECT * FROM CommunityMember inner join PostTable on CommunityMember.Member_NickName=PostTable.Post_Writer WHERE(Member_ID = '$ID')";
    $select_result=mysqli_query($db_connect,$sql);
    $select_resultRe=mysqli_query($db_connect,$sql);
    $Data=mysqli_fetch_array($select_result)


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
                         while($Post_Data = mysqli_fetch_array($select_resultRe))
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

                    
                </div>

        </div>
    </div>

    <script>
        let memberOut=document.getElementById('memberOut');
        let passwordChange = document.getElementById('nickNameChange');
        let changeInput = document.getElementById('changeInput');
        let nickName = document.getElementById('member-nickname');
        let outButton = document.getElementById('outButton');
        nickName.value = '<?php echo $Data['Member_NickName']; ?>';


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
        passwordChange.addEventListener('click', function (e) {
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