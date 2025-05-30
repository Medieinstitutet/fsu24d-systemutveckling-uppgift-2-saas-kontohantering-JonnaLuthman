<?php
require_once __DIR__ . '/../../private/init.php';
require_once __DIR__ . '/../../private/includes/mail_functions.php';
require_once __DIR__ . '/../../private/includes/user_functions.php';
require_once __DIR__ . '/../../private/includes/utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // NOTE: Constant added. Change in future when it should be sent to an actual user.
    $email = $_POST['email'];

    $reset_code = bin2hex(random_bytes(8));
    $text = "Hello, this is your reset code: $reset_code . Press following link to reset your password: http://localhost:8080/auth/change_password.php. ";
    
    if (!find_user($email)) {
        $_SESSION['message'] = 'We cannot find you email.';
        header('Location: reset_password_page.php');
        exit;
    }
    
    $to = 'jonna.luthman@hotmail.com';
    $email_result = send_email($email, "Reset password", $text);
    
    if (isset($email_result['message'])) {
        save_reset_code($email, $reset_code);
        $reset_code_result = change_password($reset_code, $email);
        $_SESSION['message'] = "Great! we have sent you an email to make sure it's really you. 
        Please check your inbox and use the code to reset your password. 
        If you cannot find the email, check you junk mail.";
        
    } else {
        $_SESSION['message'] = 'Error. Mail could not be sent. Contact us for further assistance.';
    }
}

require_once __DIR__ . '/../../private/templates/navbar.php';

?>

<main>

    <body>
        <form method="POST">
            <h2>Reset password</h2>
            <label for="email">Enter you email: </label>
            </br>
            <input name="email" />
            </br>
            <button type=submit>Reset password</button>
        </form>
        <span><a href="../login.php">Go back to login</a></span>
        <?php 
            if (!empty($_SESSION['message']) || !empty($_SESSION['error_message'])):
                display_message();
            endif; 
        ?>
    </body>
</main>

<?php
require_once __DIR__ . '/../../private/templates/footer.php';
?>