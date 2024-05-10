<?php

header("Access-Control-Allow-Origin: *");

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

$stmt = $conn->prepare("INSERT INTO regdetail (Email, Password, Username) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $Email, $Password, $Username);


if ($stmt->execute() === TRUE) {
    echo json_encode(array('success' => true));
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
