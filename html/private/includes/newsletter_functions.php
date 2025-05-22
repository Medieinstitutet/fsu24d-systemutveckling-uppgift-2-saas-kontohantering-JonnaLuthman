<?php
require_once __DIR__ . '/../config.php';

function get_newsletters()
{
    global $connection;

    $sql = 'SELECT * FROM newsletters';

    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_newsletter($id)
{
    global $connection;

    $sql = "SELECT * FROM newsletters WHERE id='$id'";

    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_array(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_newsletter_summary($id)
{
    global $connection;

    $sql = "SELECT `title`, `description` FROM newsletters WHERE id='$id'";

    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_array(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_subscriptions_by_user_id($user_id)
{
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

function create_newsletter($user_email, $title = '', $description = '')
{
    global $connection;

    $query = "INSERT INTO `newsletters`(`title`, `description`, `user_email`) VALUES ('$title','$description','$user_email')";
    $result = $connection->query($query);

    if ($result) {
        return true;
    } else {
        return false;
    }
    
}
function delete_newsletter($newsletter_id)
{
    global $connection;

    $query = "DELETE FROM `newsletters` WHERE id='$newsletter_id'";
    $result = $connection->query($query);

    if ($result) {
        return true;
    } else {
        return false;
    }
    
}

function update_newsletter($title, $description, $newsletter_id)
{
    global $connection;

    $query = ("UPDATE newsletters SET title='$title', description='$description' WHERE id='$newsletter_id'");
    $result = $connection->query($query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function user_is_subscribed($user_id, $newsletter_id)
{
    global $connection;

    $query = ("SELECT * FROM `subscriptions` WHERE `user_id` = '$user_id' AND `newsletter_id` = '$newsletter_id'");
    $result = $connection->query($query);

    return $result && $result->num_rows > 0;
}

function subscribe_to_newsletter($user_id, $newsletter_id)
{
    global $connection;

    $query = "INSERT INTO `subscriptions`(`user_id`, `newsletter_id`) VALUES ('$user_id','$newsletter_id')";
    $result = $connection->query($query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function unsubscribe_to_newsletter($user_id, $newsletter_id)
{
    global $connection;

    $query = "DELETE FROM `subscriptions` WHERE `subscriptions`.`user_id`='$user_id' and `subscriptions`.`newsletter_id` = '$newsletter_id';";
    $result = $connection->query($query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function get_newsletters_by_customer_id($user_email) {
    global $connection;

    $query = "SELECT * FROM `newsletters` WHERE user_email='$user_email'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function get_subscribers_by_newsletter_id($newsletter_id) {
      global $connection;

    $query = "SELECT user_id FROM `subscriptions` WHERE newsletter_id='$newsletter_id'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}