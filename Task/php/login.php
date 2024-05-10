<?php

header("Access-Control-Allow-Origin: *");
require('../Vendor/autoload.php');


if (empty($_POST['Email']) || empty($_POST['Password']) || empty($_POST['Username'])) {
    echo json_encode(array('success' => false, 'message' => 'Please fill all required fields.'));
    exit;
}


$Email = $_POST['Email'];
$Password = $_POST['Password'];
$Username = $_POST['Username'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logindata";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT Username, Email, Password FROM regdetail WHERE Username=? AND Email=? AND Password=?");
$stmt->bind_param('sss', $Username, $Email, $Password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

    $redis = new Predis\Client();
    $token = bin2hex(random_bytes(16));
    $redis->set('username', $Username);
    $redis->set('email', $Email);
    echo json_encode(array('success' => true, 'token' => $token, 'username', 'email'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Worng Credentials.'));
}


$stmt->close();
$conn->close();
