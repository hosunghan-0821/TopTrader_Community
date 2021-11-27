<?php

//이 부분 추가 공부 필요 , 이해 안됨
$post_data= json_decode(file_get_contents('php://input'));

//dbConnect 한번에 여러번

require_once("./dbConnect.php");
$db_connect = sqlcheck();


if($post_data->id =='') die('false');
if($post_data->check=='')die('false');

$result = null;
try{

    $select_query="SELECT $post_data->check FROM CommunityMember";
    $select_result = mysqli_query($db_connect,$select_query);
    while($Data=mysqli_fetch_array($select_result)){

        if($Data[$post_data->check]===$post_data->id){

            die('false');

        }
    }
    echo 'true';

}catch(Exception $e){
    
    die('false');
}

?>