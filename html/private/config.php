<?php
define('DB_NAME', 'saasapp');
define('DB_HOST', 'db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'notSecureChangeMe');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($connection->connect_error) {
    die("Kunde inte ansluta till databasen: " . $connection->connect_error);
}