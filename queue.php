<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include_once("consumer.php");


$consumer = new Consumer();

if($_POST['action'] == 'authenticate')
{
    $result = $consumer->authenticate($_POST['user'], $_POST['pass']);
}

if($_POST['action'] == 'recover')
{
    $result = $consumer->recovery($_POST['user']);

    if($result['rows'] > 0 && $result['email'] != '')
    {
        $send = email($_POST['user'], $result['email'], $result['password']);
        $result = $send;
    }
}

function email($user,$mail_address, $pass){

    $mail = new PHPMailer(TRUE);
    $email_response = array();
    try {
    
        $mail->setFrom('do-not-reply@helloprint.dev', 'Hellprint - Password Recovery');
        $mail->addAddress($mail_address);
        $mail->Subject = 'Your password';
        $mail->Body = "Hi $user,\n\nhere is your password:\n $pass";
        
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->Port = 2525;
        
        $mail->send();
        $mail_response['email_result'] = true;
    }
    catch (Exception $e)
    {
        $mail_response['email_result'] = false;
        $mail_response['email_result'] = $e->errorMessage();
    }
    return $mail_response;
}

echo json_encode($result);

?>