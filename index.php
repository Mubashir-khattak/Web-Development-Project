<?php
// ====================== 4. contact.php ======================
header('Content-Type: application/json');

$to = "your-email@gmail.com";   // ←←← CHANGE THIS TO YOUR EMAIL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
    $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all fields correctly']);
        exit;
    }

    $subject = "Portfolio Message from $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email\r\nReply-To: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Mail could not be sent']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>