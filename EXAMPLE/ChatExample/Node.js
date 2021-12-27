var app = require("express")();
var http = require("http").createServer(app);
var cors= require('cors');
app.use(cors());
var io = require("socket.io")(http,{
  cors:{
    origin:"*",
    methods:["GET","POST"]
  }
});



var port = 3000;
http.listen(port, () => {
  console.log("listening on *:" + port);
});

io.on('connection', function (socket) {
  console.log(socket.id, 'Connected');

  socket.emit('msg', `${socket.id} 연결 되었습니다.`);
  
  socket.on('msg', function (data) {
    console.log(socket.id, data);
    
    socket.emit('msg', `Server : "${data}" 받았습니다.`);
  });
});