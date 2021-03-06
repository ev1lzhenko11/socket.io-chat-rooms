<!doctype html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script>
  $(function () {
    var socket = io("http://server:3000/");
    var roomName = 'myRoom';
    socket.emit('joinRoom', roomName);
    $('.button').on("click",function(){
    $.ajax({
      type: 'POST',
      url: 'chat.php',
      data: {"action":"newMessage", "room": roomName, "message": $("#m").val()},
      success: function(result){
        if(result == 1){
          console.log("Успех!");
          socket.emit('addMess', roomName, $('#m').val());
          $('#m').val('');          
        }else{
          console.log("Ошибка отправки!");
        }
      }
    });


      return false;
    });

    socket.on('addMess', function(msg){
      $('#messages').append($('<li>').text(msg));
    });
  

    });
</script> 
  <head>
    <title>Socket.IO CLIENT</title>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font: 13px Helvetica, Arial; }
      form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
      form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
      form .button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages li { padding: 5px 10px; }
      #messages li:nth-child(odd) { background: #eee; }
    </style>
  </head>
  <body>
    <ul id="messages">
      <?
        $con = mysqli_connect('127.0.0.1','mysql','mysql');
        mysqli_select_db($con, 'database');
      
        $query = "SELECT message FROM messages WHERE room = 'myRoom'";  
        $result = mysqli_query($con, $query);
        while($row = $result->fetch_array(MYSQLI_NUM)){?>
          <li><?=$row[0]?></li>  
        <?}?>      

    </ul>
    <form action="/">
      <input id="m" autocomplete="off" /><span class = "button">Send</span>
    </form>
  </body>
</html>