<?php
require_once __DIR__ . '/../private/includes/mail_functions.php';
require_once __DIR__ . '/../private/includes/user_functions.php';
require_once __DIR__ . '/../private/templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // NOTE: Constant added. Change in future when it shuld be sent to an actual user.
    $email = $_POST['email'];

    $reset_code = bin2hex(random_bytes(8));
    $text = "Hello, this is your code to reset your password: $reset_code .";

    if (!find_user($email)) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found. Please register first.']);
        exit;
    }

    $to = 'jonna.luthman@hotmail.com';  
    $email_result = send_email($email, "Reset password", $text);

    if(isset($email_result['message'])) {
        $reset_code_result = save_reset_code($email, $reset_code);
        echo json_encode([
        'message' => 'Email sent with password reset.',
        'mailgun' => $email_result,
        'reset code sent' => $reset_code_result
        ]);

    } else {
        http_response_code(500);
        echo json_encode([
            'error' => 'Mail could not be sent.',
            'details' => $email_result
        ]);
    }
}
?>



