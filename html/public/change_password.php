<?php
    require_once __DIR__ . "/../private/config.php";
    require_once __DIR__ . "/../private/includes/user_functions.php";

    // TODO: put success and error message in url and use i html to show messages to user.
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reset_code = $_POST['reset_code'];
    $new_psw = $_POST['new_psw'];
    $repeat_new_psw = $_POST['repeat_new_psw'];

    $result = get_reset_code($reset_code);

    if(!$result) {
        $error = "Invalid reset code";
    } elseif ($new_psw !== $repeat_new_psw) {
        $error = "Passwords not matching";
    } else {
        $email = $result['email'];
        $change_password_result = change_password($new_psw, $email);

        if($change_password_result === true) {
            delete_reset_code($email);
            $success = "Password has been updated";
        } else {
            $error = "Could not update password";
        }
    }
    }
?>

<form method="POST">
        <label for="reset_code">Enter your reset code:</label>
        <input type="password" placeholder="Reset code" name="reset_code" required>

        <label for="new_psw">Enter a new password:</label>
        <input type="password" placeholder="New password" name="new_psw" required>

        <label for="repeat_new_psw">Enter your new password again:</label>
        <input type="password" placeholder="Repeat new password" name="repeat_new_psw" required>

        <button type="submit">Change password</button>

        <button type="button" class="cancelbtn">Cancel</button>
</form>