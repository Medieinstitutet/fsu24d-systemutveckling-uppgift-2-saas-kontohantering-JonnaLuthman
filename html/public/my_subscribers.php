<?php
session_start();
require_once __DIR__ . '/../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../private/includes/auth_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';

$user = require_signed_in_user_or_redirect();
$customer_newsletters = get_newsletters_by_customer_id($user['email']);

foreach ($customer_newsletters as $newsletter) {
    $subscribers = get_subscribers_by_newsletter_id($newsletter['id']);


    foreach ($subscribers as $subscriber) {
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

if (!$subscriber_details || count($subscriber_details) === 0) :
    echo "<p>You have no subscribers.</p>";
else : ?>
    <main>
        <h2>Your subscribers<h2>
                <ul>
                    <?php foreach ($subscriber_details as $subscriber): ?>
                        <li><?php echo "Name: " . $subscriber['name']; ?></li>
                        <li><?php echo "Email: " . $subscriber['email']; ?></li>
                        <li><?php echo "Subscribed to: " . $subscriber['newsletter']; ?></li>
                    </br>
                <?php endforeach;
                endif; ?>
                </ul>
    </main>