<?php
session_start();
require_once __DIR__ . '/../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../private/includes/auth_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';

$user = require_signed_in_user_or_redirect();
$customer_newsletters = get_newsletters_by_customer_id($user['email']);
?>
<h1>My newsletters</h1>

<ul>
    <?php foreach ($customer_newsletters as $newsletter) { ?>
        <li><?php echo $newsletter['title']; ?></li>
        <button>
            <a href="/public/edit_newsletter.php?id=<?php echo $newsletter['id']; ?>">
                Edit
            </a>
        </button>
    <?php } ?>
</ul>