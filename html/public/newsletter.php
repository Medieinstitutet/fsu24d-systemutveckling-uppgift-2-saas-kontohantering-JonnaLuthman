<?php
session_start();
require_once __DIR__ . "/../private/config.php";
require_once __DIR__ . "/../private/includes/newsletter_functions.php";
require_once __DIR__ . "/../private/includes/user_functions.php";
require_once __DIR__ . "/../private/includes/utils.php";

display_message();

$newsletter_id = $_GET['id'];
$newsletter = get_newsletter($newsletter_id);

if (!isset($_SESSION['user'])) {
    $state = 'not_logged_in';
    $user_email = null;
    $user_id = null;
} else {
    $user_email = $_SESSION['user']['email'];
    $user_id = get_user_id($user_email);

    if (user_is_subscribed($user_id, $newsletter_id)) {
        $state = 'subscribed';
    } else {
        $state = 'not_subscribed';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'subscribe':
            subscribe_to_newsletter($user_id, $newsletter_id);
            $_SESSION['message'] = "You are now subscribed to " . $newsletter['title'];
            header("Location: newsletter.php?id=" . $newsletter_id);
            break;
        case 'unsubscribe':
            unsubscribe_to_newsletter($user_id, $newsletter_id);
            $_SESSION['message'] = "Your subscription to <strong> " . $newsletter['title'] . "</strong> has been cancelled!";
            header("Location: newsletter.php?id=" . $newsletter_id);
            break;
    }
}
?>

<body>
    <main>
        <h2><?php echo $newsletter['title']; ?></h2>
        <p><?php echo $newsletter['description']; ?></h2>
        <p><?php echo "Created by:" . $newsletter['user_email']; ?></p>
        <p><?php echo $newsletter['created_at']; ?></p>

        <form method="POST">
            <?php switch ($state):
                case 'not_logged_in':
                    echo '<button><a href="/public/login.php" class="button-link">Log in to subscribe</a></button>';
                    break;
                case 'subscribed':
                    echo '<button type="submit" name="action" value="unsubscribe" onclick="window.location.reload()">Do not want to be subscribed anymore?</button>';
                    break;
                case 'not_subscribed':
                    echo '<button type="submit" name="action" value="subscribe">Subscribe</button>';
                    break;
            endswitch;
            ?>
        </form>
    </main>
</body>