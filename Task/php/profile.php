<?php
header("Access-Control-Allow-Origin: *");
require('../Vendor/autoload.php');

use MongoDB\Client;
use Predis\Client as RedisClient;

$client = new Client('mongodb://localhost:27017');

$db = $client->mydb;
$collection = $db->data;

$redis = new RedisClient();
$username = $redis->get('username');
$email = $redis->get('email');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userData = $collection->findOne(['Username' => $username]);
    if ($userData) {
        $data = [
            'Username' => $username,
            'Email' => $email,
            'Age' => $userData['Age'],
            'Dob' => $userData['Dob'],
            'Contact' => $userData['Contact']
        ];
        echo json_encode(array('success' => true, 'data' => $data));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Age = $_POST['Age'];
    $Dob = $_POST['Dob'];
    $Contact = $_POST['Contact'];
    $userData = $collection->findOne(['Username' => $Username]);
    if ($userData) {
        $updateResult = $collection->updateOne(
            ['Username' => $Username],
            ['$set' => [
                'Email' => $Email,
                'Age' => $Age,
                'Dob' => $Dob,
                'Contact' => $Contact
            ]]
        );
        if ($updateResult->getModifiedCount() > 0) {
            echo json_encode(array('success' => true, 'message' => 'Data updated successfully.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update data.'));
        }
    } else {
        $insertResult = $collection->insertOne([
            'Username' => $Username,
            'Email' => $Email,
            'Age' => $Age,
            'Dob' => $Dob,
            'Contact' => $Contact
        ]);
        echo json_encode(array('success' => true));
    }
}
