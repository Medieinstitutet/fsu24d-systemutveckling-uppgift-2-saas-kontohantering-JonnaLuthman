<?php
require_once __DIR__ . "/../../private/init.php";
require_once __DIR__ . "/../../private/includes/newsletter_functions.php";
require_once __DIR__ . "/../../private/includes/auth_functions.php";
require_once __DIR__ . "/../../private/includes/utils.php";

$user_role = require_role();

$newsletter_id = $_GET['id'] ?? '';
$newsletter = get_newsletter_summary($newsletter_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        if (delete_newsletter($newsletter_id)) {
            $_SESSION['message'] = "Newsletter deleted successfully";
            header("Location: /customer/my_newsletters.php");
            exit;
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];

        if (update_newsletter($title, $description, $newsletter_id)) {
            $_SESSION['message'] = "Newsletter updated successfully";
            header("Location: /customer/edit_newsletter.php?id=" . $newsletter_id);
            exit;
        }
    }
}

require_once __DIR__ . '/../../private/templates/navbar.php';
?>

<h1>Edit newsletter</h1>
<h3><?php echo $newsletter['title']; ?></h3>
<form method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo $newsletter['title']; ?>">

    <label for="description">Text:</label>
    <input type="textarea" name="description" value="<?php echo $newsletter['description']; ?>">

    <button type="submit">Update</button>
    <?php display_message(); ?>
</form>

<form method="post" onsubmit="return confirm('Are you sure you want to delete this newsletter?');">
    <input type="hidden" name="delete" value="1" />
    <button type="submit">Delete</button>
</form>

<a href="/customer/my_newsletters.php">Go back to my newsletters</a>

<?php
require_once __DIR__ . '/../../private/templates/footer.php';
?>