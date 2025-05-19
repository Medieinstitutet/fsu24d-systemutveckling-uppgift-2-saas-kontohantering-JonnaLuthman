<?php
    require_once __DIR__ . '/../private/templates/header.php';
?>
<main>
    <body>
    <form method="POST" action="send_reset_password.php">
    <label for="email">Enter you email: </label>
        <input name="email" />
        <button type=submit>Reset password</button>
    </form>
    </body>
</main>

<?php
    require_once __DIR__ . '/../private/templates/footer.php';
?>
