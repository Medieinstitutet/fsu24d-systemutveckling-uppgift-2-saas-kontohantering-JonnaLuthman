<?php
    require_once __DIR__ . '/../private/init.php';
    require_once __DIR__ . '/../private/includes/newsletter_functions.php';
    require_once __DIR__ . '/../private/includes/auth_functions.php';
    require_once __DIR__ . '/../private/includes/user_functions.php';
    require_once __DIR__ . '/../private/templates/navbar.php';

        $user = require_signed_in_user_or_redirect();

        $user_email = $user['email'];

        if(!require_role($user_email) === 'subscriber') {
            header("Location: /public/not_authorized.php");
        };

        $user_id = get_user_id($user_email);

        if(!$user_id) {
            echo "Could not find user id";
            exit;
        }

        $newsletters = get_subscriptions_by_user_id($user_id);

        if (!$newsletters || count($newsletters) === 0) {
            echo "<p>Du prenumererar inte på några nyhetsbrev ännu.</p>";

        } else {
            foreach ($newsletters as $newsletter):
    ?>
            <main>
            <h2>All newsletters<h2>
            <div>
                <h3><?php echo $newsletter['title']; ?></h3>
                <p><?php echo $newsletter['description']; ?></p>
                <p>Created by: <?php echo $newsletter['user_email']; ?></p>
            </div>
    <?php
            endforeach;
    }
    ?>
</main>
<?php require_once __DIR__ . '/../private/templates/footer.php'; ?>

