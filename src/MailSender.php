<?php  
    namespace lp\mailSender;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    class MailSender{
        private $mailAdress;
        private $subject;
        private $message;
        private $mail;
        private $config;


        public function __construct(array $params, $pathToPHPMailer){
            if(! is_array($params)) die('Params are invalid for MailSender')

            require_once $pathToPHPMailer.'/Exception.php';
            require_once $pathToPHPMailer.'/PHPMailer.php';
            require_once $pathToPHPMailer.'/SMTP.php';

            $this->mail = new PHPMailer(TRUE);
            $this->mail->isSMTP();
            $this->mail->Host = $params['host'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $params['user'];
            $this->mail->Password = $params['password'];
            $this->mail->SMTPSecure = $params['SMTPSecure'];
            $this->mail->Port = $params['port'];
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
        }

        public function send($mailAdress, $subject, $message, $fromAdress, $fromName){
            try{
                $this->mail->addAddress($mailAdress);
                $this->mail->Subject = $subject;
                $this->mail->Body = $message;
                $this->mail->setFrom($fromAdress, $fromName);
                $this->mail->send();
                $this->mail->clearAddresses();
                $sucess = true;
            }
            catch(\Exception $e){
                $sucess = false;
            }
            return $sucess;
        }
    }
?>