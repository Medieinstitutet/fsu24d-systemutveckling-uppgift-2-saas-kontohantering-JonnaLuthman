<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/../includes/auth_functions.php';
?>

<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="UTF-8">
  <title>Min sida</title>
  <link rel="stylesheet" href="/public/main.css">
</head>
<body>
  <header>
    <h1>Välkommen!</h1>


  <?php
    if (is_signed_in()):
        $user = current_user();
  ?>

    <div class="navbar">
        <span>Välkommen, <?php echo ($user['name']); ?>!</span>
        <form method="post" action="<?php echo BASE_PATH . 'logout.php'; ?>">
            <button type="submit">Logga ut</button>
        </form>
    </div>
  <?php else: ?>
    <div class="navbar">
        <a href="/login.php">Logga in</a>
    </div>
  <?php endif; ?>

  </header>