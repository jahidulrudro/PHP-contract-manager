<?php
$name = '';
$email = '';
$body = '';
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
}
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}
if (isset($_SESSION['body'])) {
    $body = $_SESSION['body'];
}

unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['body']);
$id=$_GET['contract_id'];
if (isset($_GET['contract_id'])) {
    $contract = Contract::find_by_id($_GET['contract_id']);
    $name = $contract->name;
    $email = $contract->email;
    $body = $contract->body;
    $signature=$contract->signature;
}
$id=$_GET['contract_id'];
?>
<?php
require('lib/PHPMailer/PHPMailerAutoload.php');//add PHPMailer autolaoder

if($_SERVER['REQUEST_METHOD']=='POST') { //checking server request method
     $id=$_POST['id'];
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
          You have received the e-contract to view and sign your <br>contract, click the link below<br>
          <br>
          <br>
          <a href='http://roommatebd.com/devid/admin/clientcopy.php?contract_id=".$id."'>Visit link to Sign your contract</a>
          <br>
          <br>
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
            $message="<p id='msg' class='alert alert-danger' style='padding-top:20px'>Mail Sent Error</p>";
           echo $message;
            
        } else {
           // echo '<span class="success">Message has been sent</span>'; //Message after successful sending of email
           $message="<p id='msg' class='alert alert-success' style='padding-top:20px'>Mail Sent Successfully</p>";
            echo $message;
        }
    }
}?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" style="margin-top: 30px">
            <form action="" method="post" id="myForm" enctype="multipart/form-data">
            <div class="panel-heading">
                <div class="text-right">
                    <input type="submit" name="send" class="btn btn-success" value="Send">
                </div>
                Preview
            </div>
            <div class="panel-body">
                 <div class="form-group" style="display: flex">
                     <div class="dr-sign-img" style="  width: 30%;">
                         <img src="image/demo.jpg" width="100px" height="50px" class="img-thumbnail"><br>
                    <label>Dr. Cherry! Baumann MD</label>

                     </div>
                    <div class="dr-sign-date" style=" width: 70%; margin-top: 40px;">
                        <label  style="border-bottom: 1px solid #222; padding-bottom: 5px;"><?= date('j F Y');?></label><br>
                    
                        <label>Date</label>
                    </div>
                </div>
                <div class="form-group" style="display: flex">
                    <div style="width: 30%;">
                        <?php if(!empty($signature)){?>
                        <img src="upload/<?php echo $signature; ?>" width="100px" height="50px" class="img-thumbnail" id="empImg">
                        <?php }else{ ?>
                        <img src="http://placehold.it/100x50" width="100px" height="50px" class="img-thumbnail" id="empImg">
                        <?php } ?>
                    <input name="file" type="file" id="contract" onchange="imagePreview(this);">
                    <label><?= $name; ?></label>
                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                    </div>
                    <div style=" width: 70%; margin-top: 40px;">
                        <label style="border-bottom: 1px solid #222; padding-bottom: 5px;"><?= date('j F Y');?></label><br>
                        <label>Date</label>
                    </div>
                </div>
            </div>
            <div class="container">
                <?= $body; ?>
                </div>
                <br><br>
                
                
            <div class="panel-footer">
                
                Contract Will Email To : <?= $email; ?>&nbsp; &nbsp;
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="id" value="<?php echo $_GET['contract_id']; ?>"
                <a href=""><button class="btn btn-warning" onclick="goback()">BACK</button></a>
                <input type="submit" name="send" class="btn btn-success" value="Send">
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function imagePreview(input) {
        if (input.files && input.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (ev) {
                $('#empImg').attr('src', ev.target.result);
            };
            fileReader.readAsDataURL(input.files[0]); 
        }
    }
</script>