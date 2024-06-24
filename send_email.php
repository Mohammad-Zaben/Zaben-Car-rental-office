<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $to = "mohammad.nail.zaben@gemail.com";  // Replace with your email address
    $headers = "From: " . $email;

    $full_message = "Name: " . $name . "\n";
    $full_message .= "Email: " . $email . "\n";
    $full_message .= "Message: " . $message;

    if (mail($to, $subject, $full_message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
} else {
    echo "Invalid request method.";
}
