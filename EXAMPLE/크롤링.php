<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

        <?php
            header('Content-Type: text/html; charset=utf-8');
            //php 에서 기본적으로 제공하는 함수 2가지 file_get_contents && file_put_contents 서버에 저장하는거까지 실습함

            //http://192.168.163.128/Web_Project_MyFirstWebPage/PHP/myHtml.php
            // $url ="http://192.168.163.128/EXAMPLE/img/record.jpg";
            // $image_contents = file_get_contents($url);

            // file_put_contents("img/new_image.jpg",$image_contents);

            include '../Web_Project_MyFirstWebPage/lib/simple_html_dom.php';

            $data= file_get_html("https://news.naver.com/main/main.naver?mode=LSD&mid=shm&sid1=101");
            $chart= file_get_html("https://finance.naver.com/");
            

            $chart_number=$chart->find("span.num_quot>span");
            // $chart_data_change= iconv("EUC-KR","UTF-8",  $chart_number[0]); 
            // echo $chart_data_change;



            foreach($chart_number as $number){
                $chart_data_change= iconv("EUC-KR","UTF-8", $number); 
                echo $chart_data_change;
                echo "</br>";
            }

            // foreach( $chart->find("div.chart_area") as $chart_data){
            //     $chart_data_change= iconv("EUC-KR","UTF-8", $chart_data); 
               
            //     $img = $chart_data->find("img");
              
            // }

            // $chart_data = $chart->find("div.chart_area");
            // $img = $chart_data[0]->find("img");
            // echo $img[0];
            
           
            // echo $chart_data;
            

        
            //$a= $data->find("div.cluster_group._cluster_content");
            //$a= $data->find("div.cluster_text>a");
            // foreach( $data->find("div.cluster_text>a") as $a){
            //     echo $a; 
            //     echo "</br>";
            // }


            // $a= $data->find("div.cluster_text>a");
            // $b= $data->find("div.cluster_text_press");
            // for($i=0; $i<10; $i++){
            //     echo $a[$i];
            //     echo "  ";
            //     echo $b[$i];
            //     echo "</br>";
            
            // }
            // echo "</br>";  echo "</br>";  echo "</br>";
            // foreach($data->find("div.cluster_text>a") as $b ){
            //     echo $b;
            //     echo "</br>";

            // }

            //div class="cluster_head_inner"
        

?>

    </body>
</html>