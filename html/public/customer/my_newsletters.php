<?php
require_once __DIR__ . '/../../private/init.php';
require_once __DIR__ . '/../../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../../private/includes/utils.php';
require_once __DIR__ . '/../../private/includes/auth_functions.php';
require_once __DIR__ . '/../../private/includes/user_functions.php';

$user = require_signed_in_user_or_redirect();
$customer_newsletters = get_newsletters_by_customer_id($user['email']);

$user_role = require_role();

if ($user_role !== 'customer') {
    header("Location: /not_authorized.php");
    exit;
}

if (count($customer_newsletters) === 0) {
    $_SESSION['message'] = "You have no newsletters. Create a newsletter<a href='/customer/create_newsletter.php'> here. </a>";
}

require_once __DIR__ . '/../../private/templates/navbar.php'; ?>

<h1>My newsletters</h1>
<?php if (!empty($_SESSION['message'])):
    display_message();
endif; ?>

<ul>
    <?php foreach ($customer_newsletters as $newsletter) { ?>
        <li>
            <?php echo htmlspecialchars($newsletter['title']); ?>
            <a href="/customer/edit_newsletter.php?id=<?php echo urlencode($newsletter['id']); ?>">
                <button>Edit</button>
            </a>
        </li>
    <?php } ?>
</ul>

<a href="/">Go back</a>

<?php
require_once __DIR__ . '/../../private/templates/footer.php';
?>