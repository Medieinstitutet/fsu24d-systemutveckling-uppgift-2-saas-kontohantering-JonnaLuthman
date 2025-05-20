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

function get_newsletter($id) {
    global $connection;

    $sql = "SELECT * FROM newsletters WHERE id='$id'";

    $result = $connection->query($sql);
    
    if ($result && $result->num_rows > 0) {
    return $result->fetch_array(MYSQLI_ASSOC);
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

function create_newsletter($user_email, $title = '', $description = '') {
    global $connection;

    $query = "INSERT INTO `newsletters`(`title`, `description`, `user_email`) VALUES ('$title','$description','$user_email')";

    try {
        $result = $connection->query($query);
        return true;
    } catch(exception $error) {
         return $error ? ['error' => $error] : ['message' => $result];
    }
}

function user_is_subscribed($user_id, $newsletter_id) {
    global $connection;

    $query = ("SELECT * FROM `subscriptions` WHERE `user_id` = '$user_id' AND `newsletter_id` = '$newsletter_id'");
    $result = $connection->query($query);

    return $result && $result->num_rows > 0;
}

function subscribe_to_newsletter($user_id, $newsletter_id){
    global $connection;

    $query = "INSERT INTO `subscriptions`(`user_id`, `newsletter_id`) VALUES ('$user_id','$newsletter_id')";
    $result = $connection->query($query);

    if($result) {
        return true;
    } else {
        return false;
    }
}

function unsubscribe_to_newsletter($user_id, $newsletter_id){
    global $connection;

    $query = "DELETE FROM `subscriptions` WHERE `subscriptions`.`user_id`='$user_id' and `subscriptions`.`newsletter_id` = '$newsletter_id';";
    $result = $connection->query($query);

    if($result) {
        return true;
    } else {
        return false;
    }
}
?>