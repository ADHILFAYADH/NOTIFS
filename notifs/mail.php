<?php
$to = "vichu@duck.com";
$subject = "Test Email";
$message = "This is a test email sent from localhost.";
$headers = "From: spac3ali3n@gmail.com" . "\r\n" .
           "Reply-To: your_email@example.com" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

// Send email
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Email sending failed.";
}
?>
