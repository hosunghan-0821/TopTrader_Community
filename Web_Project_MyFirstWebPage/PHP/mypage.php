<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';

    $db_connect=sqlCheck();
    $nickName=$_POST['nickName'];

    $sql = "SELECT * FROM CommunityMember WHERE(Member_NickName = '$nickName')";
   
    $select_result=mysqli_query($db_connect,$sql);

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
                    Top Trader<br>
                    Community</span>
                <span class="main-title">
                    회원정보
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

                            <span>닉네임 :
                            </span>
                            <input type="text" id="member-nickname">
                        </div>
                        <div class="member-data">
                            <span>이메일 :
                            </span>
                            <span id="member-email">
                                <?php echo $Data['Member_Email']; ?>
                            </span>
                        </div>
                        <div class="member-data">
                            <span>아이디 :
                            </span>
                            <span id="member-id">
                                <?php echo $Data['Member_ID']; ?></span>
                        </div>
                    </div>
                    <input type="text" id="changeInput" placeholder="변경 값을 입력하세요">
                    <div class="member-out">
                        <span id="passwordChange">비밀번호 변경</span>
                        <span id="nickNameChange">닉네임 변경</span>
                        <span id="memberOut">회원탈퇴</span>
                    </div>
                </div>
                <div class="member-wrapper">
                    관심종목</br>
            </div>

        </div>
    </div>

    <script>

        let passwordChange = document.getElementById('nickNameChange');
        let changeInput = document.getElementById('changeInput');
        let nickName = document.getElementById('member-nickname');
        nickName.value = '<?php echo $Data['Member_NickName']; ?>';

        passwordChange.addEventListener('click', function (e) {

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
                                    body: JSON.stringify({nickName : nickName.value})
                                })
                                    .then((res) => res.text())
                                    .then((data) => {
                                        console.log(data);
                                        switch (data) {
                                            case 'true':
                                                {
                                                  alert("닉네임 변경되었습니다.");
                                            
                                                }
                                            case 'false':
                                                {
                                                    alert("닉네임 변경실패.");
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