<?php
require_once __DIR__ . '/../config.php';
global $connection;

function find_user($email)
{
    global $connection;

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {

        return true;
    } else {
        return false;
    }
}

function get_user_by_id($id)
{
    global $connection;

    $query = "SELECT `name`, `email` FROM users WHERE id='$id'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return $row;
    } else {
        return [];
    }
}

function get_user_by_email($email)
{
    global $connection;

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return $row;
    } else {
        return [];
    }
}

function get_user_id($email)
{
    global $connection;

    $query = "SELECT id FROM users WHERE email='$email'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return $row['id'];
    } else {
        return [];
    }
}

function user_has_role($email)
{
    global $connection;

    $query = "SELECT role FROM users WHERE email='$email'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return $row['role'];
    } else {
        return false;
    }
}

function current_user()
{
    return $_SESSION['user'] ?? null;
}

function save_reset_code($email, $reset_code)
{
    global $connection;

    $query = "INSERT INTO `password_resets`(`email`, `reset_code`) VALUES ('$email','$reset_code')";
    $result = $connection->query($query);

    if ($result === true) {
        return ['message' => 'Reset code saved'];
    } else {
        return ['error' => $connection->error];
    }
}

function get_reset_code($reset_code)
{
    global $connection;

    $query = "SELECT email, reset_code FROM password_resets WHERE reset_code='$reset_code'";
    $result = $connection->query($query);

      if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        echo "<p>SQL-fel: " . $connection->error . "</p>";
        return null;
    }
}

function change_password($new_psw, $email)
{
    global $connection;

    $hashed_password = hash('sha256', $new_psw);

    $query = "UPDATE `users` SET `password`='$hashed_password' WHERE email='$email'";
    $result = $connection->query($query);

    if ($result === true) {
        return true;
    } else {
        return ['error' => $connection->error];
    }
}

function delete_reset_code($email)
{
    global $connection;

    $query = "DELETE FROM `password_resets` WHERE email='$email'";
    $result = $connection->query($query);

    if ($result === true) {
        return ['message' => 'Password updated'];
    } else {
        return ['error' => $connection->error];
    }
}
