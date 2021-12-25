<?php

if($_FILES['file']['size']>10240000){//10메가
            echo "-1";
            exit;
        }
        $ext = substr(strrchr($_FILES['file']['name'],"."),1);
        $ext = strtolower($ext);
        if ($ext != "jpg" and $ext != "png" and $ext != "jpeg" and $ext != "gif")
        {
            echo "-1";
            exit;
        }
        $name = "mp_".$now3.substr(rand(),0,4);
        $filename = $name.'.'.$ext;
        $destination = '../EXAMPLE/img'.$filename;
        $location =  $_FILES["file"]["tmp_name"];
        move_uploaded_file($location,$destination);

        echo '../EXAMPLE/img'.$filename;

 

?>