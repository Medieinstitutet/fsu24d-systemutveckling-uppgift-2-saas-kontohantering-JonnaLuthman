<?php


    define('BASE_PATH', '/public/');
    define('DB_NAME', 'email_list_app');
    define('DB_HOST', 'db');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'notSecureChangeMe');

    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($connection->connect_error) {
        die("Kunde inte ansluta till databasen: " . $connection->connect_error);
}
?>
