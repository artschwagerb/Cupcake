<!DOCTYPE html>
<?php
require_once("./include/membersite_config.php");

if (!$fgmembersite->CheckLogin()) {
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
include "config.php";
include TEMPLATE_PATH . "/header.php";
?>
<div class="row">
    <div class="eight columns">
        <h4>Test</h4>
        <?php
            $mail             = new PHPMailer();

            //$body             = file_get_contents('contents.html');
            //$body             = str_ireplace("[\]",'',$body);
            

            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->Host       = EMAIL_HOST; // SMTP server
            $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                                    // 1 = errors and messages
                                                    // 2 = messages only
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
            $mail->Host       = EMAIL_HOST;      // sets GMAIL as the SMTP server
            $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
            $mail->Username   = EMAIL_USERNAME;  // GMAIL username
            $mail->Password   = EMAIL_PASSWORD;            // GMAIL password

            $mail->SetFrom(EMAIL_ADDRESS, EMAIL_NAME);

            $mail->AddReplyTo(EMAIL_ADDRESS, EMAIL_NAME);

            $mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

            $body             = "test body...";
            $mail->MsgHTML($body);
            

            $address = "artschwagerb@my.uwstout.edu";
            $mail->AddAddress($address, "Brian");

            //$mail->AddAttachment("images/phpmailer.gif");      // attachment
            //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

            if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            echo "Message sent!";
            }
        ?>

    </div>

    <div class="four columns">			
        <h4>Sidebar</h4>
    </div>
</div>

<?php
include TEMPLATE_PATH . "/footer.php";
?>