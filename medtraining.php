<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

// Retrieve form data from POST or GET
$name = isset($_POST['name']) ? $_POST['name'] : $_GET['name'];
$address = isset($_POST['address']) ? $_POST['address'] : $_GET['address'];
$address2 = isset($_POST['address2']) ? $_POST['address2'] : $_GET['address2'];
$city = isset($_POST['city']) ? $_POST['city'] : $_GET['city'];
$state = isset($_POST['state']) ? $_POST['state'] : $_GET['state'];
$zip = isset($_POST['zip']) ? $_POST['zip'] : $_GET['zip'];
$degrees = isset($_POST['degrees']) ? $_POST['degrees'] : $_GET['degrees'];

// Check if form data is present
if (!empty($name) && !empty($address) && !empty($city) && !empty($state) && !empty($zip) && !empty($degrees)) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.gmail.com';
        $mail->Port = 587; // or 465
        $mail->SMTPAuth = false; // No authentication
        $mail->SMTPAutoTLS = true; // Enable TLS encryption

        // Recipients
        $mail->setFrom('dave@lookfeelandperformbetter.com', 'Dave');
        $mail->addAddress('usamtg@hotmail.com', 'Recipient Name');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Training Form Submission';
        $mail->Body = formatFormData($name, $address, $address2, $city, $state, $zip, $degrees);

        // Send the email
        $mail->send();
        // Redirect to thankyou.html on success
        header('Location: thankyou.html');
        exit();
    } catch (Exception $e) {
        // Display an alert and redirect to medical-training.html on error
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '"); window.location.href = "medical-training.html";</script>';
    }
} else {
    // Redirect to medical-training.html if form data is missing
    header('Location: medical-training.html');
    exit();
}

// Function to format the form data
function formatFormData($name, $address, $address2, $city, $state, $zip, $degrees)
{
    $formData = "<h2>Training Form Submission</h2>";
    $formData .= "<p><strong>Name:</strong> $name</p>";
    $formData .= "<p><strong>Address:</strong> $address</p>";
    if (!empty($address2)) {
        $formData .= "<p><strong>Address 2:</strong> $address2</p>";
    }
    $formData .= "<p><strong>City:</strong> $city</p>";
    $formData .= "<p><strong>State:</strong> $state</p>";
    $formData .= "<p><strong>Zip:</strong> $zip</p>";
    $formData .= "<p><strong>Credentials:</strong> $degrees</p>";

    return $formData;
}
?>