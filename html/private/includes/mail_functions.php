<?php
    require_once __DIR__ . '/../config.php';
    
    global $connection;

function send_email($to, $subject, $text, $options = []) {
    $apiKey = 'c40e587a06e85f85936483a0920cc2e7-e71583bb-e56cf7fa';
    $domain = 'sandboxdf7549abb1da4858a30a02d8f331d411.mailgun.org';

    $url = "https://api.mailgun.net/v3/$domain/messages";

    $to = $options['to'] ?? 'jonna.luthman@hotmail.com';
    $from = $options['from'] ?? 'jonna.luthman@hotmail.com';
    $name = $options['name'] ?? 'Jonna';

    $data = [
            'from'    => "$name <$from>",
            'to'      => $to,
            'subject' => $subject,
            'text'    => $text
        ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $apiKey);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    return $error ? ['error' => $error] : ['message' => $result];

}


?>