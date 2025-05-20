<?php
require_once __DIR__ . '/../private/includes/auth_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';
require_once __DIR__ . '/../private/templates/navbar.php';

$redirect_url = $_GET['redirectTo'] ?? get_login_redirect_url();

if (is_signed_in()) {
    header("Location: $redirect_url");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $registered_user = find_user($email);
    if (!$registered_user) : ?>
        <div>
            User not registered, create account
            <a href='/public/signup.php'>here</a>
        </div>;
    <?php 
    endif;

    $signed_in = sign_in($email, $password);


    if ($signed_in) {
        header("Location: $redirect_url");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<main>
    <p><strong><?php echo "Login" ?></strong></p>

    <form method="POST">
        <label for="mail">Email:</label>
        <input type="mail" placeholder="Enter your email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <input type="hidden" name="role" />

        <button type="submit">Login</button>

        <button type="button" class="cancelbtn">Cancel</button>
        <span>Forgot <a href="reset_password.php">password?</a></span>
    </form>

</main>
<?php
    require_once __DIR__ . '/../private/templates/footer.php';
?>