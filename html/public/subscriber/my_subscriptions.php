<?php
require_once __DIR__ . '/../../private/init.php';
require_once __DIR__ . '/../../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../../private/includes/auth_functions.php';
require_once __DIR__ . '/../../private/includes/user_functions.php';


$user = require_signed_in_user_or_redirect();
$user_email = $user['email'];
$user_role = require_role();

if ($user_role !== 'subscriber') {
    header("Location: /not_authorized.php");
    exit;
}

$user_id = get_user_id($user_email);
$newsletters = '';

if (!$user_id) {
    echo "Could not find user id";
    exit;
}

$newsletters = get_subscriptions_by_user_id($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe']) && !empty($_POST['unsubscribe'])) {
        $newsletter_id = $_POST['unsubscribe'];

        $result = unsubscribe_to_newsletter($user_id, $newsletter_id);

        if (!$result) {
            $_SESSION['error_message'] = "Something went wrong!";
            header("Location: newsletter.php?id=" . $newsletter_id);
            exit;
        } else {
            $_SESSION['message'] = "Your subscription has been cancelled!";
            header("Location: newsletter.php?id=" . $newsletter_id);
            exit;
        }
    }
}

require_once __DIR__ . '/../../private/templates/navbar.php';

?>

<main>
    <h2>My subscriptions</h2>

    <?php if (!$newsletters || count($newsletters) === 0) {
    ?> <p>You are not subscribing to any newsletters yet.</p>
        <a href="../index.php">See all newsletters</a>
        <?php } else {
        foreach ($newsletters as $newsletter):
        ?>
            <div>
                <h3><?php echo $newsletter['title']; ?></h3>
                <p><?php echo $newsletter['description']; ?></p>
                <form method="POST">
                    <button type="submit" name="unsubscribe" value="<?php echo $newsletter['id']; ?>">
                        Unsubscribe
                    </button>
                </form>
                </form>
            </div>
    <?php
        endforeach;
    }
    ?>
</main>
<?php require_once __DIR__ . '/../../private/templates/footer.php'; ?>