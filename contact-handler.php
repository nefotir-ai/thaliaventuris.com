<?php
/**
 * Thalia Venturis Partners — contact form handler.
 * Validates the POST from /Contacts/, emails the lead, returns JSON.
 *
 * Configure the destination address via env var CONTACT_TO_EMAIL if set,
 * otherwise falls back to the default below.
 */

header('Content-Type: application/json');

$to = getenv('CONTACT_TO_EMAIL') ?: 'social@thaliaventuris.com';

function respond($ok, $error = null) {
    http_response_code($ok ? 200 : 422);
    echo json_encode(['ok' => $ok, 'error' => $error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.');
}

// Honeypot — bots tend to fill every field, humans never see this one.
if (!empty($_POST['company_website'])) {
    // Pretend success so bots don't learn the honeypot worked.
    respond(true);
}

$name    = trim($_POST['name'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $phone === '' || $email === '' || $address === '' || $message === '') {
    respond(false, 'Please fill in all required fields.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.');
}

// Basic header-injection guard on single-line fields.
foreach ([$name, $phone, $email, $address] as $field) {
    if (preg_match('/[\r\n]/', $field)) {
        respond(false, 'Invalid input.');
    }
}

$subject = 'New website inquiry from ' . $name;

$body = "New lead from thaliaventuris.com/Contacts/\n\n"
      . "Name:    $name\n"
      . "Phone:   $phone\n"
      . "Email:   $email\n"
      . "Address: $address\n\n"
      . "Message:\n$message\n";

$headers = [
    'From: Thalia Venturis Website <no-reply@thaliaventuris.com>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'X-Mailer: PHP/' . phpversion(),
];

$sent = mail($to, $subject, $body, implode("\r\n", $headers));

if (!$sent) {
    respond(false, 'We could not send your message right now. Please try again shortly.');
}

respond(true);
