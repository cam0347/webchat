<?php
	require "info_db.php";
	$username = $_GET["user"];
	$password = $_GET["pwd"];
	
	date_default_timezone_set("Europe/Rome");
	
	function output($str) {
	    $json = new stdClass();
	    $json -> status = $str;
	    echo json_encode($json);
	}
	
	$sql = mysqli_connect("127.0.0.1", $user, $pwd, $db);
	
	if ($sql -> connect_error) {
	    output("sql error");
	}
	
	try {
	    $res = $sql -> query("select * from Users where username = '$username' and password = '$password'");
	
	    $time = date("Y-m-d H:i:s");
	    $sql -> query("insert into Accesses (user, date) values ('$username', '$time')");
	
	    if ($sql -> affected_rows == 1) {
	        $row = $res -> fetch_all()[0];
	        if ($row[0] == $username && $row[1] == $password) {
	            output("ok");
	        }
	    } else {
	        output("denied");
	    }
	} catch (Throwable $th) {
	    output("trycatch error");
	}
?>
