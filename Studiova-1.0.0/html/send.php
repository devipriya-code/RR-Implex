<?php
// send.php
header("Content-Type: application/json");

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

// Sanitize Inputs
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid email address."]);
    exit;
}

// Email content
$to = "paletteproductiondevelopers@gmail.com";  // ← CHANGE THIS
$subject = "New Contact Form Message from $name";

$body = "Name: $name\n";
$body .= "Email: $email\n\n";
$body .= "Message:\n$message\n";

$headers = "From: noreply@paletteproductiondevelopers@gmail.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(["status" => "success", "message" => "Message sent successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error sending message."]);
}
