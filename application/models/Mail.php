<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Model {
 function sendmail($fromemail,$fromName,$emailaddress,$subject=FLASE,$message=FALSE,$attachment=FALSE){
        $this->load->library('parser');
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->isHTML(true); 

        $mail->Host         = 'mailrelay.edis.at'; //smtp.google.com
        $mail->SMTPAuth     = true;     
        $mail->Username     = 'support@maatdrive.com';  
        $mail->Password     = 'MaatSupport1.';
        $mail->SMTPSecure   = 'STARTTLS';  
        $mail->Port         = 587;

        // $mail->Host     = 'maatdrive.app';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'master@maatdrive.app';
        // $mail->Password = 'SupportMaatdrive1';
        // $mail->SMTPSecure = 'STARTTLS';
        // $mail->Port     = 587;
        
        $mail->setFrom($fromemail, $fromName);
        $mail->addReplyTo($fromemail, $fromName);
        
        // Add a recipient
        $mail->addAddress($emailaddress);
        
        // Add cc or bcc 
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = $subject;
        if($attachment!=FLASE)
        $mail->addAttachment("$attachment");
        // Set email format to HTML
        //$mail->addAttachment("logo/english.png");
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $message;
        $mail->Body = $mailContent;
        
        // Send email
         if(!$mail->send()){
            // echo 'Message could not be sent.';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            //echo 'Message has been sent';
        }
        //exit;
      
    }

  
  

  
}