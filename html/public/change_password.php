<?php
require_once __DIR__ . "/../private/init.php";
require_once __DIR__ . "/../private/config.php";
require_once __DIR__ . "/../private/includes/user_functions.php";
require_once __DIR__ . "/../private/includes/utils.php";


// TODO: put success and error message in url and use i html to show messages to user.


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reset_code = $_POST['reset_code'];
    $new_psw = $_POST['new_psw'];
    $repeat_new_psw = $_POST['repeat_new_psw'];

    $result = get_reset_code($reset_code);

    if (!$result) {
        $_SESSION['error_message'] = "Invalid reset code";
    } elseif ($new_psw !== $repeat_new_psw) {
        $_SESSION['error_message'] = "Passwords not matching";
    } else {
        $email = $result['email'];
        $change_password_result = change_password($new_psw, $email);

        if ($change_password_result === true) {
            delete_reset_code($email);
            $_SESSION['message'] = "Your password has been updated! Go back to login <a href='/public/login.php'> here </a>";
            // header(Location: "/public/login.php?message=passwordupdated")
        } else {
            $_SESSION['error_message'] = "Could not update password";
        }
    }
}

require_once __DIR__ . "/../private/templates/navbar.php";

?>

<div>
    <p>
        <?php if (!empty($_SESSION['message']) || !empty($_SESSION['error_message'])) {
            display_message();
        } ?>
    </p>
</div>
<form method="POST">
    <label for="reset_code">Enter your reset code:</label>
    <input type="password" placeholder="Reset code" name="reset_code" required>

    <label for="new_psw">Enter a new password:</label>
    <input type="password" placeholder="New password" name="new_psw" required>

    <label for="repeat_new_psw">Enter your new password again:</label>
    <input type="password" placeholder="Repeat new password" name="repeat_new_psw" required>

    <button type="submit">Change password</button>
</form>
<?php require_once __DIR__ . "/../private/templates/footer.php"; ?>