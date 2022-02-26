<?php
require "info_db.php";

$minID = $_GET["minID"]; //last message received by the client
$ip = $_SERVER["REMOTE_ADDR"];

$sql = mysqli_connect("127.0.0.1", $user, $pwd, $db);

if ($sql -> connect_error) {
    $json = new stdClass();
    $json -> status = "error";
    $json -> messages = [];
    echo json_encode($json);
    exit();
}

$res = $sql -> query("select m.ID, m.date, m.user, m.text, u.IP from Messages m inner join Users u on m.user = u.username where ID > " . $minID);
$messages = $res -> fetch_all();

$json = new stdClass();
$json -> status = "ok";
$json -> messages = [];

foreach ($messages as $msg) {
    $_json = new stdClass();
    $_json -> ID = $msg[0];
    $_json -> date = $msg[1];
    $_json -> user = $msg[2];
    $_json -> msg = $msg[3];

    if ($msg[4] == $ip) {
        $_json -> user = "yourself";
    }

    $json -> messages[] = $_json;
}

echo json_encode($json);
?>