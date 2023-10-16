<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $to = "202238166@spu.ac.za";
    $subject = "Contact Form Submission from $name";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Message:\n$message";

    if (mail($to, $subject, $email_body, $headers)) {
        echo "Thank you for your submission. We will get back to you soon.";
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    echo "Invalid request. Please submit the form.";
}
?>


