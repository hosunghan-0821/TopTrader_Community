
//서버 담당을 하는 express 이게 뭔지 조사해보자

//express는 node.js를 활용하게 좀 더 편리하게 해주는 웹프레임워크 
var app = require("express")();
//서버 담당을 하는 app 변수(express) 를 이용하여 http 만들자 이 코드에 대한 해석도 필요

//서버 생성하기
var http = require("http").createServer(app);
const bodyParser = require('body-parser');
//cors 오류를 막기 위해서 적어주는 것, cors 오류에 대해서도 정리해놓자.!!
var cors= require('cors');
app.use(cors());
app.use(bodyParser.json()); // body-parser 사용
//express로 사용하여 http 서버를 만들어둔 것을 socket.io server upgrade한다 어떤 의미인가..?
// http 서버를 socket io를 지원하는 서버로 업그레이드 한다
var io = require("socket.io")(http,{
  cors:{
    origin:"*",
    methods:["GET","POST"]
  }
});

// 내가 사용할 포트 3000 번 방화벽으로 3000번 해제하고, 포트도 ufw 를 활용하여 열어줬을 떄 , 연결이 가능했다.
// 포트를 열어주는게 포인트!!

var port = 3000;


//만들어진 서버는 3000번 포트를 listen 하고 있다.
http.listen(port, () => {
  console.log("listening on *:" + port);
});
var chatArray = new Array();

app.use('/test', (req, res) => {
  res.json({chatUser : chatArray});
})

// 연결이 됬을 때, socket.emit을 통해서, 메시지를 전달한다.
io.sockets.on('connection', function (socket) {
  console.log(socket.id, 'Connected');
  
  //입장시 회원 등록하기
  socket.on('connectUser',function(name){
    chatArray.push(name);
    // chatArray.forEach(element => {
    //   console.log(element);
    //   if(element=="ㅇㅇ"){
    //     console.log("요소가 ㅇㅇ 입니다");
    //     socket.emit('mustDisconnect',"true");
    //   }
    // });
    console.log(chatArray);
  });

  //입장시 입장 알림 보내기
  socket.on('newUserConnect',function(name){
    // console.log(socket.id, name);
    socket.emit('socketId',socket.id);
    socket.name=name;

    var message= socket.name + '님이 입장했습니다.';
    // console.log(socket.name,message);
    io.sockets.emit('updateMessage',{
      name: 'SERVER',
      message : message
    });
   
  });

  //퇴장시 입장 알림 보내기
  socket.on('disconnect',function(){
    var message = socket.name + '님이 퇴장했습니다.';
    // console.log(socket.name,message);
    for(let i=0;i<chatArray.length;i++){
      if(chatArray[i]==socket.name){
        chatArray.splice(i, 1);
        i--;
        console.log(chatArray);
      }
    }
    socket.broadcast.emit('updateMessage',{
      name: 'SERVER',
      message : message
    });
  })

  //메세지가 왔을 때, 그에 해당하는 내용 뿌려주기
  socket.on('sendMessage', function (data) {
    // console.log(socket.id, data);
    data.name=socket.name;
    data.socketId=socket.id;
    io.sockets.emit('updateMessage',data);
  });



});

//여기서 해야될 것이 연결되어 있는 모든 client에 정보를 전송하는 방식이 필요하다.
