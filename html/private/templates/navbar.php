<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../includes/user_functions.php";
require_once __DIR__ . "/../includes/auth_functions.php";
?>

<nav class="navbar">
  <ul>
    <li><a href="/">Home</a></li>
    <?php if (!is_signed_in()): ?>
      <li><a href="/signup.php">Sign up</a></li>
      <li><a href="/login.php">Sign in</a></li>
    <?php elseif (is_signed_in()): ?>

      <?php if ($_SESSION['user']['role'][0] === "subscriber"): ?>
        <li><a href="/subscriber/my_subscriptions.php">My subscriptions</a></li>

      <?php elseif ($_SESSION['user']['role'][0] === "customer") : ?>
        <li><a href="/customer/my_newsletters.php">My newsletters</a></li>
        <li><a href="/customer/my_subscribers.php">My subscribers</a></li>
        <li><a href="/customer/create_newsletter.php">Create newsletter</a></li>

      <?php endif; ?>
      <li><a href="/logout.php">Sign out</a></li>
    <?php endif; ?>
  </ul>
</nav>