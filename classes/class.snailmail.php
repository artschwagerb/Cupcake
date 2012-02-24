<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of snailmail
 *
 * @author Brian
 */
require_once( CLASS_PATH . "/class.phpmailer.php");
class snailmail {
    //put your code here
    function __construct() {
        
    }
    
    function passwordchange($email) {
        //$this->recipient("artschwagerb@my.uwstout.edu");
        //$this->subject("Password Changed");
        //$this->message("Your password was changed on 2/23/12 by 144.13.123.123");
        //$this->send();
        
    }
    
    function newUser($user) {
        //Email Stuff
            $mail = new PHPMailer();

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
            $mail->AddBCC($user->email, $user->username);
           
        
            //More Email Stuff
        //echo print_r($users);
        
            
            $mail->Subject    = $_POST['email-subject'];

            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!                     ".$_POST['email-message']; // optional, comment out and test

            $body             = $_POST['email-message'];
            $mail->MsgHTML($body);
            
            //$mail->AddAttachment("images/phpmailer.gif");      // attachment
            //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

            if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
                return 1;
            } else {
                return 0;
            //echo "Message sent!";
            }
    }
}
?>
