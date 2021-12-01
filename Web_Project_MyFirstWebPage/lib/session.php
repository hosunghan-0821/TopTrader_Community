<?php

session_start();
$loginCheck;
if(!isset($_SESSION['is_login'])){
    $loginCheck="false";
}
else{
    $loginCheck="true";
}
?>