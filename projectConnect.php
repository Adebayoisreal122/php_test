<?php

$host= 'localhost';
$username= 'root';
$password= '';
$db= 'teststudent_db';

$connection= new mysqli ($host, $username, $password, $db);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
    // echo "Connected Successfully";
}
?>