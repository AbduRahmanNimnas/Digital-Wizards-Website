<?php

// Replace this with your own email address
$siteOwnersEmail = 'info@digitalwizardagency.com';

if ($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Initialize the $error array
    $error = [];

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }
    // Check Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }
    // Subject
    if (empty($subject)) {
        $subject = "Contact Form Submission";
    }

    // Set Message
    $message = "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Set From: header
    $from = $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (empty($error)) {
        // Test simplified email sending
        $test_mail = mail('abdulnimnas@gmail.com', 'Test', 'This is a test email.');

        if ($test_mail) {
            echo "Test email sent successfully. ";
        } else {
            echo "Test email sending failed. ";
        }

        ini_set("sendmail_from", $siteOwnersEmail); // for windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK"; // Successful submission
        } else {
            echo "Something went wrong. Please try again."; // Email sending failed
        }
    } else {
        $response = isset($error['name']) ? $error['name'] . "<br /> \n" : null;
        $response .= isset($error['email']) ? $error['email'] . "<br /> \n" : null;
        $response .= isset($error['message']) ? $error['message'] . "<br />" : null;

        echo $response; // Validation errors
    }
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

}
?>
