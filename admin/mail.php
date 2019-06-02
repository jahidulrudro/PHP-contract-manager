<?php
require('lib/PHPMailer/PHPMailerAutoload.php');//add PHPMailer autolaoder

if($_SERVER['REQUEST_METHOD']=='POST') { //checking server request method
   
    if(empty($_POST['email']))
    {
        echo  "<span class='error'>Email field can not be empty</span>";
        //$message="Email can not be empty";
    }else{
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //sanitizing email field input
    }
    if(empty($_POST['name']))
    {
      echo "<span class='error'>Name can not be empty</span>";
     // $message="Name can  not be empty";
    }else{
        $name=filter_var($_POST['name'],FILTER_SANITIZE_STRING); //sanitize name
    }
  
    //Check whether all are filed or not and spam cheker input is correct
    if (!empty($name) && !empty($email)) {
        $mail = new PHPMailer; //create instance of PHPMailer class
        //$mail->isSMTP();                                      // Set mailer to use SMTP
      //  $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
        //$mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'user@example.com';                 // SMTP username
        //$mail->Password = 'secret';                           // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 587;                                    // TCP port to connect to
        $mail -> charSet = "UTF-8"; //set email character set to Unicode
        $mail->setFrom('noreply@me.com', 'David'); //Set from address "email","name"
        $mail->addAddress($email, $name); // Add a recipient replace with your one 
        $mail->addAddress('add a new reciepeint email');               // Add a new recipient name is optional          
        $mail->addReplyTo('noreply@me.com', 'David');//add reply to path
        //$mail->addCC('cc@example.com'); //for cc
        //$mail->addBCC('bcc@example.com'); //For Bcc
        //Attaching multiple attachement with email
        //Check the attachment field is set and not empty
        $message="
          <p>
          Dear ".ucfirst($name).",
          <br>
          You have received the e-contract to view and sign your <br><br>contract, click the link below<br><br>
          <a href='http://roommatebd.com'>http://roommatebd.com</a>
          <br>
          Regards,
          <br>
          Admin

          </p>
        ";
        
        $mail->isHTML(true); // Set email format to HTML
        if(!empty($subject)) { 
            $mail->Subject = $subject; //set subject if user wrote it
        }else{
            $mail->Subject="Contract Form to Sign"; //set default subject if user leave sibject field empty
        }
        $mail->Body = $message; //message body

        if (!$mail->send()) {
            //echo '<span class="error">Message could not be sent.Mailer Error: ' . $mail->ErrorInfo.'</span>'; //Message if there any error
            $message="<span class='alert alert-danger'>Mail Sent Error</span>";
            echo $message;
            
        } else {
           // echo '<span class="success">Message has been sent</span>'; //Message after successful sending of email
           $message="<span class='alert alert-success'>Ment Sent Successfully</span>";
            echo $message;
        }
    }
}