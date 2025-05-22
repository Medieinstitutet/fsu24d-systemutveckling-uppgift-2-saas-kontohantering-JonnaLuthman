<?php
require_once __DIR__ . '/../private/init.php';
require_once __DIR__ . '/../private/includes/mail_functions.php';
require_once __DIR__ . '/../private/includes/newsletter_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'] ?? 'Unknown';
    $subject = $_POST['subject'] ?? 'No subject';
    $text = $_POST['text'] ?? 'Empty message';
    $name = $_POST['name'] ?? 'Anonymous';

if(empty($from)) {
    $_SESSION['error_message'] = 'No sender address given.';
    header('Location: send_newsletter.php');
    exit;
}

if (!find_user($from)) {
    $_SESSION['error_message'] = 'User not found. Please register first.';
    header('Location: send_newsletter.php');
    exit;
}

$to = 'jonna.luthman@hotmail.com';  
$email_result = send_email($to, $subject, $text, $from, $name);

if(isset($email_result['message'])) {
    $newsletter_result = create_newsletter($from, $subject, $text);
    echo json_encode([
    'message' => 'Email sent and newsletter created.',
    'mailgun' => $email_result,
    'newsletter_saved' => $newsletter_result
    ]);

} else {
    http_response_code(500);
    echo json_encode([
        'error' => 'Mail could not be sent.',
        'details' => $email_result
    ]);
}

}