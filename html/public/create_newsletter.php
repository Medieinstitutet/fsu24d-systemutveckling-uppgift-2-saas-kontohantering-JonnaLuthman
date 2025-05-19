<form method="POST" action="send_newsletter.php">
    <label for="name">Your name:</label>
    <input type="text" name="name" required>

    <label for="email">Your email:</label>
    <input type="email" name="from" required>

    <label for="subject">Subject:</label>
    <input type="text" name="subject" required>

    <label for="text">Message:</label>
    <input type="text" name="text" required>

    <button type="submit">Send</button>
</form>