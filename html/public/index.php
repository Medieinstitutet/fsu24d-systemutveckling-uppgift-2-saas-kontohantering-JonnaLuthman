<?php
require_once __DIR__ . '/../private/init.php';
require_once __DIR__ . '/../private/config.php';
require_once __DIR__ . '/../private/templates/navbar.php';
require_once __DIR__ . '/../private/templates/header.php';
require_once __DIR__ . '/../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';

$user = current_user();
?>

<main>
    <h2>All newsletters</h2>

    <?php
    $newsletters = get_newsletters();

    if (count($newsletters) > 0):
        foreach ($newsletters as $newsletter):

    ?>
            <div>
                <h3><?php echo $newsletter['title']; ?></h3>
                <p><?php echo $newsletter['description']; ?></p>
                <p>Created by:
                    <?php $user = get_user_by_email($newsletter['user_email']);
                    echo $user['name']; ?>
                </p>
                <a href="newsletter.php?id= <?php echo $newsletter['id']; ?>">Read more</a>
            </div>
    <?php
        endforeach;
    else:
        echo "<p>Inga newsletters hittades.</p>";
    endif;
    ?>
</main>


<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>