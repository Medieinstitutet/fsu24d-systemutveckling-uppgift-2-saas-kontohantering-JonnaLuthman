<?php
require_once __DIR__ . '/../config.php';

function get_newsletters() {
    global $connection;

    $sql = 'SELECT * FROM newsletters';

    $result = $connection->query($sql);
    
    if ($result && $result->num_rows > 0) {
    return $result->fetch_all(MYSQLI_ASSOC);
    } else {
    return [];
    }
}

function get_user_subscriptions($user_id) {
    global $connection;

    $sql = "SELECT newsletters.*
            FROM newsletters
            INNER JOIN subscriptions ON newsletters.id = subscriptions.newsletter_id
            WHERE subscriptions.user_id = '$user_id'";

        $result = $connection->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
}
?>