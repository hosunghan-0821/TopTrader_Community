<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <?php
        $db = mysqli_connect("192.168.163.128","hosung","ghtjd114");

        if($db){
            echo "connect : 성공 <br>";
        }
        else{
            echo "disconnect :실패 <br>";
        }

        $result = mysqli_query($db, 'SELECT VERSION() as VERSION');
        $data = mysqli_fetch_assoc($result);
        echo $data['VERSION'];

        
    ?>
    제대로 들어갔는지확인
    </body>
</html>
