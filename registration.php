<?php
require "info_db.php";
$data = file_get_contents('php://input');
$json = json_decode($data);
$username = $json -> user;
$password = $json -> pwd;
$ip = $_SERVER["REMOTE_ADDR"];

function output($status) {
    $obj = new stdClass();
    $obj -> status = $status;
    echo json_encode($obj);
    exit();
}

$sql = mysqli_connect("127.0.0.1", $user, $pwd, $db);

if ($sql -> connect_error) {
    output("db connection error");
}

$sql -> query("insert into Users values ('$username', '$password', 'online', '$ip')");

if ($sql -> affected_rows == 1) {
    output("ok");
} else {
    output("sql error");
}
?>