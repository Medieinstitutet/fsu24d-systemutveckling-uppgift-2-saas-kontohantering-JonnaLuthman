<?php
session_start();
require_once __DIR__ . "/../private/config.php";
require_once __DIR__ . "/../private/includes/newsletter_functions.php";
require_once __DIR__ . "/../private/includes/utils.php";

$newsletter_id = $_GET['id'] ?? '';
$newsletter = get_newsletter_summary($newsletter_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (update_newsletter($title, $description, $newsletter_id)) {
        $_SESSION['message'] = "Newsletter updated successfully";
        header("Location: edit_newsletter.php?id=" . $newsletter_id);
        exit;
    }
}
?>

<h1>Edit newsletter</h1>
<h3><?php echo $newsletter['title']; ?></h3>
<form method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo $newsletter['title']; ?>">

    <label for="description">Text:</label>
    <input type="textarea" name="description" value="<?php echo $newsletter['description']; ?>">

    <button type="submit">Update</button>
    <?php
        display_message();
    ?>
</form>