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

function get_user_id($email) {
    global $connection;

    $query = "SELECT id FROM users WHERE email='$email'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return $row['id'];
    } 
    else {
        return [];
    }
}

function current_user() {
    return $_SESSION['user'] ?? null;
}
?>