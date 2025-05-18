<?php
require_once __DIR__ . '/../config.php';
global $connection;

function sign_up($name, $email, $password, $role) {
    global $connection;

        // $salt = SALT;
        // $hashed_password = hash('sha256', $password.$salt);

        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

        try {
            $result = $connection->query($query);
            return true;
        } catch (Exception $e) {
            return false;
        }
}

function sign_in($email, $password) {
    global $connection;

    // $salt = SALT;
    // $hashed_password = hash('sha256', $password.$salt);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
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

function is_signed_in() {
    return isset($_SESSION['user']);
}

function sign_out() {
    if (is_signed_in()) {
        
        session_unset();
        session_destroy();
        
        
        header('Location: signedOut.php');
        exit;
    } else {
        echo "Utloggning misslyckades – du var inte inloggad.";
    }
}

function require_signed_in_user_or_redirect() {

    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
        header("Location: /public/login.php");
        exit;
    }
    return $_SESSION['user'];
}

// functoin require_role() {

// }
?>
