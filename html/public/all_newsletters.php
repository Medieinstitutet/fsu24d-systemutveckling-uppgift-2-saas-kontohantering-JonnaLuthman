<?php
    require_once __DIR__ . '/../private/init.php';
    require_once __DIR__ . '/../private/config.php';
    require_once __DIR__ . '/../private/templates/navbar.php';
    require_once __DIR__ . '/../private/includes/newsletter_functions.php';
?>

<main>
    <h2>All newsletters<h2>

    <?php
        $newsletters = get_newsletters();

        if (count($newsletters) > 0):
            foreach ($newsletters as $newsletter):
    ?>
            <div>
                <h3><?php echo $newsletter['title']; ?></h3>
                <p><?php echo $newsletter['description']; ?></p>
                <p>Created by: <?php echo $newsletter['user_email']; ?></p>
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