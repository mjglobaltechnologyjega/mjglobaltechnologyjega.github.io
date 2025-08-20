<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $to = "mjglobaltechnology1@gmail.com";
        $subject = "New Contact Message from " . $name;
        $headers = "From: " . $email . "\r\n" .
                   "Reply-To: " . $email . "\r\n" .
                   "Content-Type: text/html; charset=UTF-8";
        
        $email_body = "<h3>New Contact Form Submission</h3>";
        $email_body .= "<p><strong>Name:</strong> " . $name . "</p>";
        $email_body .= "<p><strong>Email:</strong> " . $email . "</p>";
        $email_body .= "<p><strong>Message:</strong><br>" . nl2br($message) . "</p>";
        
        if (mail($to, $subject, $email_body, $headers)) {
            echo "Message sent successfully!";
        } else {
            echo "Error sending email. Please try again later.";
        }
    } else {
        echo "Please fill in all fields correctly.";
    }
}
?>
