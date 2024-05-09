<?php
session_start();

require 'phpMail/src/Exception.php';
require 'phpMail/src/PHPMailer.php';
require 'phpMail/src/SMTP.php';
require 'dompdf/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Print the request method for debugging



// Check if any data was received
if (isset($_POST["printContents"])) {
    // Decode the JSON data


    // Now you have the JSON data as an associative array
    $htmlContent = $_POST["printContents"];




  

    // Replace the <img> tag in your HTML content with the base64-encoded image
    
    $html = $htmlContent;


    // Create a PDF object
    $pdf = new Dompdf\Dompdf();

    // Load HTML content
    $pdf->loadHtml($html);

    // Render the PDF (optional: set paper size, orientation, etc.)
    $pdf->setPaper('A3', 'portrait');

    // Render the PDF
    $pdf->render();

    // Get the PDF content
    $pdfContent = $pdf->output();

    $pdfFilename = sys_get_temp_dir() . '/bill.pdf'; // Specify the filename directly
    file_put_contents($pdfFilename, $pdfContent);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = ''; // Your Gmail email address
    $mail->Password = ''; // Your Gmail app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom(''); // Your Gmail email address
    $mail->addAddress('');//to Gmail Address

    $mail->addAttachment($pdfFilename);

    // Content
    $mail->isHTML(true);
    $mail->Subject = '';//subject
    $mail->Body = '';//content

    if ($mail->send()) {
        echo "Email sent successfully!";
    } else {
        echo "Email sending failed. Error: " . $mail->ErrorInfo;
    }

    unlink($pdfFilename);

} else {
    // Handle the case where no data was received in the POST request
    echo "No data received.";
}

?>