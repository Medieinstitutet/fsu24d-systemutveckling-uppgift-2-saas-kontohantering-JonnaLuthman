<?php
    require_once __DIR__ . '/../private/templates/header.php';
?>

<body>
    <?php echo "index" ?>

    <?php
        echo '<pre>';
            print_r($_SESSION);
        echo '</pre>';    
    ?>
    <main>
        <p>Det här är min startsida.</p>
    </main>
    
</body>

<?php
    require_once __DIR__ . '/../private/templates/footer.php';
?>