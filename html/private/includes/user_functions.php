<?php
require_once __DIR__ . '/../config.php';
global $connection;

function find_user($email) {
    global $connection;

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {

    return true;    
    } else {
       return false;  
    }
}
?>