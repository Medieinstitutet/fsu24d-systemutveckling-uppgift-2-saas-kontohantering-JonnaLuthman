<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/user_functions.php';
global $connection;

function sign_up($name, $email, $password, $role)
{
    global $connection;
    $hashed_password = hash('sha256', $password);
    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
    $result = $connection->query($query);

    if (!$result) {
        die("SQL-fel: " . $connection->error);
    }

    return true;
}

function sign_in($email, $password)
{
    global $connection;

    $hashed_password = hash('sha256', $password);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password' LIMIT 1";
    $result = $connection->query($query);
    $has_user = ($result->num_rows === 1);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        unset($user['password']);
        $user['role'] = explode(",", $user['role'] ?? 'user');

        $_SESSION['user'] = $user;

        return $user;
    } else {
        return false;
    }
}

function is_signed_in()
{
    return isset($_SESSION['user']);
}

function sign_out()
{
    if (is_signed_in()) {
        session_unset();
        session_destroy();

        header('Location: signed_out.php');
        exit;
    } else {
        echo "Utloggning misslyckades – du var inte inloggad.";
    }
}

function require_signed_in_user_or_redirect()
{
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
        header("Location: /public/login.php");
        exit;
    }
    return $_SESSION['user'];
}

function require_role()
{
    $user = require_signed_in_user_or_redirect();
    $user_role = user_has_role($user['email']);

    return $user_role;
}

function email_registered($email)
{
    global $connection;

    $query = "SELECT email FROM `users` WHERE email = '$email'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
