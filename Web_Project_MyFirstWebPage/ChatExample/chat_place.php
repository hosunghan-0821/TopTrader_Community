<?php
  $roomName=$_GET['chat'];
  $asd;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Socket.io Test</title>
  <link rel="stylesheet" href="../CSS/chat.css">
  <script src="/Web_Project_MyFirstWebPage/ChatExample/node_modules/socket.io/client-dist/socket.io.js" ></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!-- <div id="chatContent">

  </div>
  <input id="myChat" type="text"> -->

  <div>
    <div id="info"><?=$roomName ?></div>
    <div class="chatWindow" id="chatWindow"></div>
    <div class="userInput">
      <input class="userText" id="chatInput" type="text" placeholder="채팅을 입력하세요">
      <button class="sendMessage" id="chatMessageSendBtn" > 입력 </button>
    </div>
  </div>



  <script>
   
    let roomName='<?= $roomName; ?>';
    var socketId;
    //들어오자마자 스크립트를 통해 바로 connect 된다.
    var socket = io.connect('http://192.168.163.131:3000',{
        cors:{origin:'*'}
        ,transports:['websocket']
    });
    //연결이 됬을 경우, user가 선택한 이름을 보내고,  그 이름에 해당하는 소켓 생성
    socket.on('connect',function(){
      console.log("123456");
      socket.emit('joinRoom', roomName, "호성");
    });
    socket.on('joinRoom',function(roomName,name){
      console.log(roomName);
      console.log(name);
    });
    // //연결될 경우 소켓id 를 client에게 제공
    // socket.on('socketId',function(data){
    //   socketId=data;
    //   console.log(socketId);
    // })
    // // socket.on('mustDisconnect',function(data){
    // //   if(data=="true"){
    // //     console.log("dd");
    // //     socket.close();
    // //   }
    // // });
    // var chatWindow= document.getElementById('chatWindow');
    // //socket 에게 msg를 받아서 화면에 뿌려주는 용도.

    // socket.on('updateMessage', function (data) {

    //     var chatMessageEl= drawChatMessage(data);
    //     chatWindow.appendChild(chatMessageEl);
    //     //스크롤 알아서 내려오게 해주는 코드
    //     chatWindow.scrollTop = chatWindow.scrollHeight;
    
    // });

    // //채팅을 자바스크립트 함수 drawChatMessage()를 활용하여 가져온 정보 화면에뿌리기.
    // function drawChatMessage(data){

    //   var wrap = document.createElement('p'); 
    //   var message = document.createElement('span');
    //   var name = document.createElement('span');

    //   // name.innerText=data.name+" : ";
    //   message.innerText=data.message;

    //   name.classList.add('chat-name');
    //   message.classList.add('chat-message');


    //   if(data.name==='SERVER'){
    //     //서버알림일 경우
    //     name.innerText=data.name+" : ";
    //     wrap.classList.add('chat-server');
    //   }
      
    //   else if(data.socketId===socketId){
       
    //     //내가 직접 쓴  글일 경우.
    //     wrap.classList.add('chat-mine');
    //   }
    //   else{
    //     console.log(data.socketId,socketId);
    //     //상대방이 쓴 글일 경우
    //     name.innerText=data.name+" : ";
    //     wrap.classList.add('chat-other');
    //   }

    //   wrap.appendChild(name);
    //   wrap.appendChild(message);
    //   return wrap;

    // }

    // // 사용자 입력란, 전송란
    // var sendButton= document.getElementById('chatMessageSendBtn');
    // var chatInput= document.getElementById('chatInput');

    // sendButton.addEventListener('click',function(){

    //   var message= chatInput.value;
    //   if(!message){
    //     return false;
    //   }
    //   socket.emit('sendMessage',{
    //     message
    //   });
    //   chatInput.value='';
    

    // });
    // chatInput.addEventListener('keyup',function(){
    //   if(window.event.keyCode==13){
    //         var message= chatInput.value;
    //       if(!message){
    //         return false;
    //       }
    //       socket.emit('sendMessage',{
    //         message
    //       });
    //       chatInput.value='';
    //   }
    // });

    // // chat입력란에, 엔터키를 입력했을시 , input안에 있는 내용을 client화면에
    // //보냅니다 라고 나오고, socket에게 emit 전송한다. 이 값을.
    // //서버에 전송한다
    // // $("#myChat").on("keyup", function () {

    // //   if (window.event.keyCode == 13) {
    // //     $("#chatContent").append(` ${name} : "${$(this).val()}" .<br>`);
    // //     socket.emit('msg', $(this).val());
    // //     $(this).val("");
    // //   }

    // // });
    
  </script>

</body>

</html>