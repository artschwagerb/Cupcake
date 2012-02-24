<?php

class admin {
	
    function addUser(){
        //if($_SESSION['status_of_user'] == 9){
            $dbstuff = new databee();
            $dbstuff->execute("INSERT INTO u_user (name, email, username, password, confirmcode, displayname, status_id, last_ip, premium_ex_date) VALUES ('".addSlashes($_POST['user-name'])."', '".addSlashes($_POST['user-email'])."', '".addSlashes($_POST['user-username'])."', MD5('".addSlashes($_POST['user-password'])."'), 'y', '".addSlashes($_POST['user-displayname'])."', '".addSlashes($_POST['user-status_id'])."', 'never logged in', '".addSlashes(date($_POST['user-premium_ex_date']))."')");
            
            $idofnewuser = mysql_insert_id();
            $user = new user($idofnewuser);
            
            //Email the User
            $mail             = new PHPMailer();

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
            $mail->Subject    = "Welcome to Cupcake";
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

            $body             = "<h4>Welcome<h4><a href='http://cupcakesfor.me'>Check here to Login</a><p>Here is the information you will need</p><p><b>Username: </b>".$user->username."<br /><b>Password: </b>".$_POST['user-password']."</p>";
            $mail->MsgHTML($body);
            
            $mail->AddAddress($user->email, $user->displayname);

            if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
                return 0;
            } else {
                return $idofnewuser;
            }

    }
    
    function emailUsers(){
        
            //Email Stuff
            $mail             = new PHPMailer();

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

            //DB STUFF
            $dbstuff = new databee();
            $res = $dbstuff->query("SELECT id FROM u_user WHERE status_id>0 and email<>'';");

            if(mysql_num_rows($res) != 0){
                    while($row = mysql_fetch_assoc($res)) {
                        $user = new user($row['id']);
                        $mail->AddBCC($user->email, $user->username);
                    }
            }
        
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