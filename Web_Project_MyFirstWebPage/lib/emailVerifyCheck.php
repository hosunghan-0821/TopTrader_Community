<?php

   

    $postData=json_decode(file_get_contents('php://input'));
    $verifyNumber = rand(1000,10000);
    
    // echo $verifyNumber;
    // echo "</br>";
    $to =  $postData->email;
    // $to="winsomed96@naver.com";
    $subject = 'Top-trader-Community 이메일 인증 ';
    $message = '이메일 인증 확인 칸의 다음 값을 넣어주세요 '.$verifyNumber;
    //$headers = 'From : root@topTraderCommunity.com'."\r\n";
    $mail_from='From : root@topTraderCommunity.com';
    $fname='한호성';
    $header = "Return-Path: <$mail_from>\n";
    $header .= "From: $fname <$mail_from>\n";

    //sendmail 여기서 설정 잘 해야 빠르다. 메일서버 존재해가지고 smtp인가뭔가  
    

    $mailResult=mail($to,$subject,$message,$header);
    // echo $verifyNumber;
    if($mailResult){
        echo $verifyNumber;
    }
    else{
        echo 'false';
    }

    

?>