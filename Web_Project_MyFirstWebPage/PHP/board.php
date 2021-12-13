<?php
     //게시글 관련 파일
   
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';
    header("Cache-Control: no-cache");
    $db_connect=sqlCheck();

    //paging 처리를 위한 코드 
    
    if(isset($_POST['page'])){
        $page = $_POST['page'];
    }
    else{
        $page=1;
    }

    if(isset($_POST['search-category'])){
        $searchCategory=$_POST['search-category'];
        $searchText=$_POST['search-text'];
        if($searchCategory=="제목"){
          
            $sqlBoard="SELECT * FROM PostTable where Post_Title LIKE '%$searchText%' ";
        }
        else if ($searchCategory=="작성자"){
            $sqlBoard="SELECT * FROM PostTable  WHERE (Post_Writer='$searchText' ) ";
        }
    }
    else{
        $searchCategory="null";
        $searchText="null";
        $sqlBoard="SELECT * FROM PostTable";
    }
    
    $boardResult = mysqli_query($db_connect,$sqlBoard);
    
    // 게시글 총 갯수
    $totalPostNumber =mysqli_num_rows($boardResult);

    //내가 한 페이지당 몇개씩 보여줄 것인가?
    $list = 5;
    $blockCnt=5;
    //현재 페이지 블록
    $blockNum=ceil($page/$blockCnt);
    //블록 시작 숫자
    $blockStart=(($blockNum-1)*$blockCnt)+1;
    //블록 마지막
    $blockEnd=$blockStart+$blockCnt-1;

    // 총 게시글 / 리스트 갯수 = 총 페이지 갯수
    $totalPage= ceil($totalPostNumber/$list);

    // 전체 페이지보다 현재 블록 end가 크다면,  
    //마지막 page는 현재 block end값.
    if($blockEnd>$totalPage){
        $blockEnd=$totalPage;
    }
    $totalBlock= ceil($totalPage/$blockCnt);
    $pageStart = ($page-1)*$list;

    //여기까지 GET으로 부턴 Page를 갖고 필요한 변수들 정의 한 부분.
    //$sqlPage="SELECT * FROM PostTable ORDER BY Post_Date DESC Limit $pageStart,$list";
    


    //게시글 글쓴이, 제목을 갖고 search 하기위해서 넘어온 정보에 따라  query 해서 정보를 뿌려주기

    if(isset($_POST['search-category'])){
       $searchCategory=$_POST['search-category'];
       $searchText=$_POST['search-text'];

       //제목일 경우, 작성자일 경우 나눠서 query
       if($searchCategory=="제목"){
           //$select_query="SELECT * FROM PostTable WHERE Post_Title LIKE '%$searchText%' ORDER BY Post_date desc ";
           $sqlPage="SELECT * FROM PostTable WHERE Post_Title LIKE '%$searchText%' ORDER BY Post_date desc Limit $pageStart,$list ";
       }
       else if($searchCategory=="작성자"){
           //$select_query="SELECT * FROM PostTable WHERE (Post_Writer='$searchText' ) ORDER BY Post_date desc";
           $sqlPage="SELECT * FROM PostTable WHERE (Post_Writer='$searchText' ) ORDER BY Post_date desc Limit $pageStart,$list";
       }
    }
    else{
        //$select_query = "SELECT Post_Writer,Post_Number,Post_Title,Post_Like,Post_View,Post_Date from PostTable ORDER BY Post_date desc " ;
        $sqlPage="SELECT * FROM PostTable ORDER BY Post_Date DESC Limit $pageStart,$list";
    }

    $select_result=mysqli_query($db_connect,$sqlPage);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/border.css">
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap"
            rel="stylesheet">
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

        <div class="board-list-wrap">

            <div class="board-list-category">
                <a href="../PHP/board.php">
                    자유게시판
                </a>

            </div>
            <div class="board-list">

                <div class="board-list-head">
                    <div class="num">번호</div>
                    <div class="title">제목</div>
                    <div class="writer">글쓴이</div>
                    <div class="date">작성일</div>
                    <div class="view">조회</div>

                </div>

                <div class="board-list-body" id="postBody">

                <?php
                    //위에서 query한 정보로 순서대로 뿌려주는 코드 
                    
                    while($Data = mysqli_fetch_array($select_result))
                    {

                        $Post_Writer=$Data['Post_Writer'];
                        $Post_Number=$Data['Post_Number'];
                        $Post_Title=$Data['Post_Title'];
                        //$Post_Content=$Data['Post_Content'];
                        $Post_Date = $Data['Post_Date'];
                        $Post_View=$Data['Post_View'];
                        $dateTime=explode(" ", $Post_Date);
                        $nowDate= date("Y-m-d");
                        if($nowDate===$dateTime[0]){
                            $boardTime=$dateTime[1];
                        }
                        else{
                            $boardTime=$dateTime[0];
                        }
                        if($Post_Writer==null){
                            $Post_Writer="탈퇴한 회원.";
                        }
                
                     ?>

                    <div class="item">

                        <div class="num" id="num"><?= $Post_Number; ?></div>
                        <div class="title">
                            <a href="boardRead.php?num=<?php echo $Post_Number?>"><?php echo $Post_Title; ?></a>
                        </div>
                        <div class="writer"><?php echo $Post_Writer; ?></div>
                        <div class="date"><?php echo $boardTime; ?></div>
                        <div class="view"><?php echo $Post_View; ?></div>

                    </div>

                    <?php 
                    }
                    ?>
                </div>

            </div>

      
            <div class="paging">

                 <?php 
                
                    if( $totalPostNumber !=0 ){

                        if($page>1){
                            $pre =$page-1;
                        }
                        else{
                            $pre=1;
                        }
                       
                        echo"<a onclick='pageChange(1)' class='first'> 처음</a>"; 
                        // echo"<a href='board.php?page=1' class='first'> 처음</a>"; 
                        echo"<a onclick='pageChange($pre)' class='previous'> 이전 </a>";
                        // echo"<a href='board.php?page=$pre' class='previous'> 이전 </a>";
                    }
                  
                ?>
                
                <?php 
                    for($i= $blockStart; $i<=$blockEnd;$i++){

                        if($page ==$i){
                            echo "<b> $i </b>";
                        }
                        else{
                            // echo "<a href='board.php?page=$i' class='num'>$i</a>";
                            echo "<a onclick='pageChange($i)'>$i</a>";
                        }
                    }
                ?>

                <?php
                    if($totalPostNumber!==0){

                        if($page<$totalPage){
                            $next=$page+1;
                        }
                        else{
                            $next=$totalPage;
                        }
                        echo "<a onclick='pageChange($next)'> 다음</a>";
                        // echo "<a href='board.php?page=$next'> 다음</a>";
                        echo "<a onclick='pageChange($totalPage)'> 마지막</a>";
                        //echo "<a href='board.php?page=$totalPage'> 마지막</a>";
                    }
                
                ?>

                <div class="write" onclick="writeFunction()">
                    글쓰기
                </div>
            </div>

            <div class="bottom-content">
                <div class="bottom-content-item">
                    <div class="bottom-search-category">
                        <form action="../PHP/board.php" method="post" id="search-form">

                            <select
                                name="search-category"
                                id="search-category"
                                onchange="changePlaceholder()">
                                <option value="제목">제목</option>
                                <option value="작성자">작성자</option>
                            </select>
                        </div>
                        <div class="bottom-search">

                            <input
                                type="text"
                                name="search-text"
                                class="search-text"
                                id="search-text"
                                placeholder="제목 입력">
                        </form>

                    </div>
                    <div id="bottom-search-button" class="bottom-search-button">
                        검색
                    </div>
                </div>

            </div>

        </div>

        <script>



            //bottom search 관련 자바스크립트 [검색 관련 스크립트]
           
            let searchCategory = document.getElementById("search-category");
            let searchText = document.getElementById("search-text");
            let searchButton = document.getElementById("bottom-search-button");
            let searchForm = document.getElementById("search-form");

        
            
            if("<?php echo $searchCategory;?>" != "null"){
                if("<?php echo $searchCategory; ?>" == "제목"){
                    searchCategory.value="제목";
                }
                else{
                    searchCategory.value="작성자";
                }
                searchText.value="<?php echo $searchText; ?>";
              
            }
            else{
                console.log("456");
            }


            // 만들어진 페이징 링크를 누를 때, 검색 정보가 있을 경우 같이 정보전달 하기위해 form만들어서 전달
          
            function pageChange(pageNum){

          
                console.log(pageNum);
                var obj= {
                    page : pageNum
                };
                //넘겨야 할 것들 page 번호, 검색종류, 검색어 
                if("<?php echo $searchCategory;?>" != "null"){

                    if("<?php echo $searchCategory; ?>" == "제목"){
                        obj["search-category"] = "제목";
                    }
                    else{
                        obj["search-category"]="작성자";
                    }
                  obj["search-text"]=searchText.value;
                }

            
             
                let form = document.createElement('form');
                form.setAttribute('method', 'post');
                form.setAttribute('action', '../PHP/board.php');
                for (var key in obj){
                    var hiddenField = document.createElement('input');
                    hiddenField.setAttribute('type', 'hidden');
                    hiddenField.setAttribute('name', key);
                    hiddenField.setAttribute('value', obj[key]);
                    form.appendChild(hiddenField);
                }
                document.body.appendChild(form);
                form.submit();

            }

            searchButton.addEventListener('click', function (e) {
                if (searchText.value == "") {
                   
                    searchText.focus()
                    return false;
                } else {
                    searchForm.submit();
                }
            })

            function changePlaceholder() {
                if (searchCategory.value == "제목") {
                    searchText.placeholder = "제목 입력"
                } else if (searchCategory.value == "작성자") {
                    searchText.placeholder = "작성자 입력"
                }
            }

            //로그인 관련 스크립트
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

            function writeFunction() {
               
                 document.location.href = 'boardStandardWrite.php';
            }
            // function readFunction() {

            // }
        </script>

    </body>
</html>