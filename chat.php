<?php
	require "info_db.php";
	
	$ip = $_SERVER["REMOTE_ADDR"];
	$token = $_COOKIE["token"];
	$sql = mysqli_connect("127.0.0.1", $user, $pwd, $db);
	
	if ($sql -> connect_error) {
	    header("Location: error.html");
	    exit();
	}
	
	$sql -> query("select * from Users where token = '$token'"); //prova
	
	if ($sql -> affected_rows != 1) {
	    header("Location: error.html");
	}
?>

<html>
    <head>
        <title>WebChat</title>
        <script type="text/javascript" src="js/chat.js" defer></script>
        <link rel="stylesheet" href="css/chat.css" />
        <meta charset="UTF-8" />
    </head>
    <body onload="init()">
        <div id="chat">
            <section id="messageContainer">
                <section class="messages" id="messages"></section>
            </section>
            <section id="control">
                <div class="textboxContainer">
                    <input type="text" placeholder="Scrivi qualcosa" class="textbox" spellcheck="false" id="textbox" />
                </div>
                <div class="buttonContainer">
                    <input type="button" class="sendButton" onclick="sendMessage()" />
                </div>
            </section>
        </div>
    </body>
</html>
