<?php
require_once __DIR__ . '/../private/includes/auth_functions.php';
require_once __DIR__ . '/../private/includes/newsletter_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';


    $result = sign_up($name, $email, $password, $role);

    if ($result) {
        sign_in($_POST['email'], $_POST['password']);
        $user = current_user();
        if ($_POST['role'] === "customer") {
            $result = create_newsletter($user['email'], 'First newsletter', 'Thank you for registrating!');
            header('Location: /all_newsletters/?message=created');
            exit;
        } else {
            header('Location: /all_newsletters/?message=notCreated');
            exit;
        }
    }
}
?>
<main>
    <p><strong>
            <Create account>
        </strong></p>
    <form method="POST">
        <label for="fullname">Firts and last name:</label>
        <input type="text" placeholder="First and last name:" name="name" required>

        <label for="email">Email:</label>
        <input type="email" placeholder="Enter your email" name="email" required>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="customer">Customer</option>
            <option value="subscriber">Subscriber</option>
        </select>

        <label for="password">Password:</label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <button type="submit">Login</button>

        <button type="button" class="cancelbtn">Cancel</button>
    </form>
</main>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>