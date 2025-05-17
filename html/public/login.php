<?php
    session_start();
    require_once __DIR__ . '/../private/includes/auth_functions.php';

?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    }

    $signed_in = sign_in($_POST['username'], $_POST['password']);

    if ($signed_in) {
        header("Location: allNewsletters.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }

?>

<main>
    <p><strong><?php echo  "Login" ?></strong></p>

    <form method="POST">
            <label for="username">Username:</label>
            <input type="text" placeholder="Enter username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <input type="hidden" name="role" />

            <button type="submit">Login</button>

            <button type="button" class="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="resetPassword.php">password?</a></span>
    </form>

</main>


<?php
    require_once __DIR__ . '/../private/templates/header.php';
    require_once __DIR__ . '/../private/templates/footer.php';
?>