<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/dbConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Web_Project_MyFirstWebPage/lib/session.php';

    $db_connect=sqlCheck();
    $post_data= json_decode(file_get_contents('php://input'));
    
    $nickName=$_POST['nickName'];
  

?>