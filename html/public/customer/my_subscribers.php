<?php
require_once __DIR__ . '/../../private/init.php';
require_once __DIR__ . '/../../private/config.php';
require_once __DIR__ . '/../../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../../private/includes/auth_functions.php';
require_once __DIR__ . '/../../private/includes/user_functions.php';
require_once __DIR__ . '/../../private/includes/utils.php';

$user = require_signed_in_user_or_redirect();
$customer_newsletters = get_newsletters_by_customer_id($user['email']);
$subscriber_details = [];

$user_role = require_role();

if ($user_role !== 'customer') {
    header("Location: /not_authorized.php");
    exit;
}


foreach ($customer_newsletters as $newsletter) {
    $newsletter_subscribers = get_subscribers_by_newsletter_id($newsletter['id']);

    foreach ($newsletter_subscribers as $subscriber) {
        $user_details = get_user_by_id($subscriber['user_id']);
        if ($user_details) {
            $subscriber_details[] = [
                'name' => $user_details['name'],
                'email' => $user_details['email'],
                'newsletter' => $newsletter['title']
            ];
        }
    }
}

if (empty($subscriber_details)) {
    $_SESSION['message'] = "You have no subscribers! Don't worry, they are coming. You are awesome :)";
}

require_once __DIR__ . '/../../private/templates/navbar.php';
?>
<main>
    <h2>Your subscribers</h2>
    <?php if (!empty($_SESSION['message'])):
        display_message();
    endif; ?>
    <ul>
        <?php if (!empty($subscriber_details)) {
            foreach ($subscriber_details as $subscriber): ?>
                <li><?php echo "Name: " . htmlspecialchars($subscriber['name']); ?></li>
                <li><?php echo "Email: " . htmlspecialchars($subscriber['email']); ?></li>
                <li><?php echo "Subscribed to: " . htmlspecialchars($subscriber['newsletter']); ?></li>
                <br>
        <?php endforeach;
        }
        ?>
    </ul>
</main>
<?php
require_once __DIR__ . '/../../private/templates/footer.php';
?>