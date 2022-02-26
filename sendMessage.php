<?php
require "info_db.php";

date_default_timezone_set("Europe/Rome");
$msg = file_get_contents('php://input');
$token = $_COOKIE["token"];
$date = date("Y-m-d H:i:s");

if ($msg == null || $msg == "") {
    $json = new stdClass();
    $json -> status = "error";
    echo json_encode($json);
    exit();
}

$sql = mysqli_connect("127.0.0.1", $user, $pwd, $db);

if ($sql -> connect_error) {
    $json = new stdClass();
    $json -> status = "error";
    echo json_encode($json);
    exit();
}

try {
    $res = $sql -> query("insert into Messages (text, user, date) values ('$msg', (select username from Users where token = '$token'), '$date')");

    $json = new stdClass();

    if ($sql -> affected_rows == 1) {
        $json -> status = "sent";
    } else {
        $json -> status = "error";
    }

    echo json_encode($json);
} catch (Throwable $th) {
    $json = new stdClass();
    $json -> status = "trycatch error";
    echo json_encode($json);
    exit();
}
?>