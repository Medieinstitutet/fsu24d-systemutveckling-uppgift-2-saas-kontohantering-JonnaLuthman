<?php 
require_once __DIR__ . '/../private/init.php';
require_once __DIR__ . '/../private/includes/mail_functions.php';
require_once __DIR__ . '/../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';
require_once __DIR__ . '/../private/includes/utils.php';
require_once __DIR__ . '/../private/templates/navbar.php';

$user = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? 'No title';
    $description = $_POST['description'] ?? 'Empty message';


if (!find_user($user['email'])) {
    $_SESSION['error_message'] = 'User not found. Please register first.';
    header('Location: send_newsletter.php');
    exit;
}

$newsletter_result = create_newsletter($user['email'], $title, $description);
    if(!$newsletter_result) {
            $_SESSION['error_message'] = 'Could not create newsletter';
    } else {
        $_SESSION['message'] = 'Newsletter created succesfully. Go to <a href="/public/my_newsletters.php">My newsletters</a> to see your newsletters.';
    }
}
?>

<h1>Create newsletter</h1>
<form method="POST">
    <input type="hidden" name="email" value= <?php echo $user['email']; ?> >

    <label for="title">Title:</label>
    <input type="text" name="title" required>

    <label for="description">Description:</label>
    <input type="text" name="description" required>

    <button type="submit">Send</button>
</form>

<?php if (!empty($_SESSION['message'])):
    display_message();
endif;

require_once __DIR__ . '/../private/templates/footer.php'; 
?>