<?php
namespace NewdichMail;
use NewdichSchema\Settings;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NewdichMailer{
    private $dataneed;

    public function __construct(array $dataneed){
        $this->dataneed = $dataneed;
    }

    public function sendOtp(){
        try{
            $htmlcontent ="Email content in html format here";
            $nonhtmlcontent ="Email content in plain text here";

            $mail = new PHPMailer(true);
            //set server settings
            $mail->isSMTP();
            $mail->Host= Settings::APP_SMTP;
            $mail->SMTPAUTH=true;
            $mail->Username= Settings::APP_OTP_EMAIL;
            $mail->Password= Settings::APP_OTP_EMAIL_PASSWORD;
            $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port= (int) Settings::APP_PORT;
            //Set Recipients
            $mail->setFrom(Settings::APP_OTP_EMAIL);
            $mail->addAddress($this->dataneed->email, $this->dataneed->fullname);
            //set content
            $mail->isHTML(true);
            $mail->Subject=ucwords($this->dataneed->action);
            $mail->Body= $htmlcontent;
            $mail->AltBody= $nonhtmlcontent;
            $mail->send();
            return json_encode(array("status"=>"success", "response"=>"Email successfully sent"), JSON_PRETTY_PRINT);
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }


    public function send(){
        try{
            $htmlcontent ="Email content in html format here";
            $nonhtmlcontent ="Email content in plain text here";

            $mail = new PHPMailer(true);
            //set server settings
            $mail->isSMTP();
            $mail->Host= Settings::APP_SMTP;
            $mail->SMTPAUTH=true;
            $mail->Username= Settings::APP_SENDING_EMAIL;
            $mail->Password= Settings::APP_SENDING_EMAIL_PASSWORD;
            $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port= (int) Settings::APP_PORT;
            //Set Recipients
            $mail->setFrom(Settings::APP_SENDING_EMAIL);
            $mail->addAddress($this->dataneed->email, $this->dataneed->fullname);
            //set content
            $mail->isHTML(true);
            $mail->Subject=ucwords($this->dataneed->action);
            $mail->Body= $htmlcontent;
            $mail->AltBody= $nonhtmlcontent;
            $mail->send();
            return json_encode(array("status"=>"success", "response"=>"Email successfully sent"), JSON_PRETTY_PRINT);
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }
}
?>