<?php
session_start();
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../includes/user_functions.php";
require_once __DIR__ . "/../includes/auth_functions.php";

?>
<nav>
  <ul>
    <li><a href="/public/all_newsletters.php">Home</a></li>
    <?php
    if (!is_signed_in()): ?>
      <li><a href="/public/signup.php">Sign up</a></li>
      <li><a href="/public/login.php">Sign in</a></li>
      <?php elseif (is_signed_in()): ?>
  

        <?php if ($_SESSION['user']['role'][0] === "customer"): ?>
          <li><a href="/public/dashboard_customer.php">Dashboard</a></li>
          <li><a href="/public/my_subscriptions.php">My subscriptions</a></li>
          <li><a href="/public/logout.php">Sign out</a></li>

        <?php elseif ($_SESSION['user']['role'][0] === "subscriber") : ?>
          <li><a href="/public/dashboard_subscriber.php">Dashboard</a></li>
          <li><a href="/public/my_newsletters.php">My newsletters</a></li>
          <li><a href="/public/my_subscribers.php">My subscribers</a></li>

        <?php endif; ?>

            <li><a href="/public/logout.php">Sign out</a></li>
      <?php endif; ?>
  </ul>
</nav>