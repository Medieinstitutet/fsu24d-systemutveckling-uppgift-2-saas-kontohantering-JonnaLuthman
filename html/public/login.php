<?php
require_once __DIR__ . '/../private/init.php';
require_once __DIR__ . '/../private/config.php';
require_once __DIR__ . '/../private/includes/auth_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';
require_once __DIR__ . '/../private/includes/utils.php';

$redirect_url = $_GET['redirectTo'] ?? get_login_redirect_url();

if (is_signed_in()) {
    header("Location: $redirect_url");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $registered_user = find_user($email);
    $signed_in = sign_in($email, $password);

    if ($signed_in):
        header('Location: /public/all_newsletters.php');
        exit;
    elseif (!$registered_user):
        $_SESSION['error_message'] = 'User does not exist';
        header('Location: login.php');
        exit;
    else:
        $_SESSION['error_message'] = 'Invalid password';
        header('Location: login.php');
        exit;
    endif;
}

require_once __DIR__ . '/../private/templates/navbar.php'; ?>

<main>
    <p><strong><?php echo "Login" ?></strong></p>

    <?php if (!empty($_SESSION['error_message'])):
        display_message();
    endif; ?>

    <form method="POST">
        <label for="mail">Email:</label>
        </br>
        <input type="mail" placeholder="Enter your email" name="email" required>
        </br>
        <label for="password">Password:</label>
        </br>
        <input type="password" placeholder="Enter Password" name="password" required>
        </br>
        <input type="hidden" name="role" />
        </br>
        <button type="submit">Sign in</button>
        <span>Forgot <a href="reset_password_page.php">password?</a></span>

    </form>

    <span>Not registered? Sign up <a href="signup.php">here</a></span>

</main>
<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>