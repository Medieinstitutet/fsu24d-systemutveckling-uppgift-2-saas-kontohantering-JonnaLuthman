<?php
require_once __DIR__ . '/../init.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/../includes/auth_functions.php';
require_once __DIR__ . '/../includes/user_functions.php';
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
    <?php
    if (is_signed_in()):
      $user = current_user();
    
    ?>
    <div class="header">
      <h1>Welcome, <?php echo ($user['name']); ?>!</h1>
    </div>
  <?php else: ?>
  <div class="header">
      <h1>Welcome!</h1>
    </div>
     <?php endif; ?>
  </header>