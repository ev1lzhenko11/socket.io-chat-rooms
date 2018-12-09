var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res, io){
   res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
	 
	socket.on('joinRoom', function(room){
		socket.join(room);
	});

	socket.on('addMess', function(room, msg){
		io.sockets.to(room).emit('addMess', msg);
	});

});

http.listen(3000, function(){
  console.log('Chat started!');
});