<?
	if($_POST["action"] == "newMessage"){
	
		$con = mysqli_connect('127.0.0.1','mysql','mysql');
		mysqli_select_db($con, 'database');
	
		$query = "INSERT INTO messages (room, message) VALUES ("."'".$_POST["room"]."'".","."'".$_POST["message"]."'".")";	
	
		$result = mysqli_query($con, $query);
		
		echo $result;
	}

?>