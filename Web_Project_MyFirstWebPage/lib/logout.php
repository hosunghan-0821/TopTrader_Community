<?php
    session_start();
    session_destroy();
    echo "<script>
    alert('로그아웃'); 
    document.location.href='../PHP/myHtml.php';
    </script>";
?>