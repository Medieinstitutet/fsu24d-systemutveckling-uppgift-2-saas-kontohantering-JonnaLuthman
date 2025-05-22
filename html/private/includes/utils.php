<?php
function display_message() {
    if (isset($_SESSION['message'])):
        echo "<p class='message'>{$_SESSION['message']}</p>";
        unset($_SESSION['message']);
    elseif (isset($_SESSION['error_message'])):
        echo "<p style='color: red;'>{$_SESSION['error_message']}</p>";
        unset($_SESSION['error_message']);
    endif;
}
?>