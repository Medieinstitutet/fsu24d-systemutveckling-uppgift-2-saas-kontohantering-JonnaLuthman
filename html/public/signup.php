<?php
require_once __DIR__ . '/../private/init.php';
require_once __DIR__ . '/../private/includes/utils.php';
require_once __DIR__ . '/../private/includes/auth_functions.php';
require_once __DIR__ . '/../private/includes/newsletter_functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    $user_already_exists = email_registered($email);
    if ($user_already_exists):
        $_SESSION['error_message'] = "User already exists, try signing in instead.";
    else:
        $result = sign_up($name, $email, $password, $role);

        if ($result) {
            sign_in($_POST['email'], $_POST['password']);
            $user = current_user();
            if ($_POST['role'] === "customer"):
                $result = create_newsletter($user['email'], 'First newsletter', 'Thank you for registrating!');
                header('Location: /?message=created');
                exit;
            elseif ($_POST['role'] === "subscriber"):
                header('Location: /');
                exit;
            endif;
        }
    endif;
}
require_once __DIR__ . '/../private/templates/navbar.php';
?>
<main>
    <h1><strong>
            Sign up
        </strong></h1>

    <?php if (!empty($_SESSION['error_message'])) { ?>
        <p><?php display_message(); ?></p>
    <?php } ?>

    <form method="POST">
        </br>
        <label for="fullname">First and last name:</label>
        <input type="text" placeholder="First and last name:" name="name" required>

        </br>
        <label for="email">Email:</label>
        <input type="email" placeholder="Enter your email" name="email" required>

        </br>
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="customer">Customer</option>
            <option value="subscriber">Subscriber</option>
        </select>

        </br>
        <label for="password">Password:</label>
        <input type="password" placeholder="Enter Password" name="password" required>
        <div>
            <span type="button"><a href="login.php">Go back</a></span>
            <button type="submit">Create account</button>
        </div>
    </form>
</main>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>