<?php
require_once __DIR__ . '/../private/init.php';
require_once __DIR__ . '/../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../private/includes/utils.php';
require_once __DIR__ . '/../private/includes/auth_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';
require_once __DIR__ . '/../private/templates/navbar.php';

$user = require_signed_in_user_or_redirect();
$customer_newsletters = get_newsletters_by_customer_id($user['email']);

if (count($customer_newsletters) === 0) {
    $_SESSION['message'] = "You have no newsletters. Create a newsletter<a href='/public/create_newsletter.php'> here. </a>";
} ?>

<h1>My newsletters</h1>
    <?php if (!empty($_SESSION['message'])):
        display_message();
    endif; ?>

<ul>
    <?php foreach ($customer_newsletters as $newsletter) { ?>
        <li>
            <?php echo htmlspecialchars($newsletter['title']); ?>
            <a href="/public/edit_newsletter.php?id=<?php echo urlencode($newsletter['id']); ?>">
                <button>Edit</button>
            </a>
        </li>
    <?php } ?>
</ul>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>