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
        $mail->Host     = 'mail.maatdrive.app';
        $mail->SMTPAuth = true;
        $mail->Username = 'mostofa@maatdrive.app';
        $mail->Password = 'GDG%$#24488';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $mail->IsHTML(true);
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

    function send($emailaddress,$subject,$message){
        // Load PHPMailer library
        $emailaddress='golam.mostofa@bdventura.com';
        if($emailaddress=='atiqul.islam1@bdventura.com')  $emailaddress='atiqul.islam@bdventura.com';
        if($emailaddress=='shurid.khandokar2@bdventura.com')  $emailaddress='shurid.khandokar@bdventura.com';

        $this->load->library('phpmailer_lib');
        $this->load->library('parser');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host     = 'mail.maatdrive.app';
        $mail->SMTPAuth = true;
        $mail->Username = 'mostofa@maatdrive.app';
        $mail->Password = 'GDG%$#24488';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsHTML(true);
        $mail->setFrom('it@vlmbd.com', 'VLMBD');
        $mail->addReplyTo('it@vlmbd.com', 'VLMBD');
        // Add a recipient
        $mail->addAddress($emailaddress);
        
        // Add cc or bcc 
        //$mail->addCC('cc@example.com');
        $mail->addBCC('golam.mostofa@bdventura.com');
        // Email subject
        $mail->Subject = $subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $message;
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            //echo 'Message has been sent';
        }
        //exit;
    }

  
  

  
}