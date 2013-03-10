<?php 
    /**
     * The mail utils to send mails
     * @author linbin
     */
    require_once 'class.phpmailer.php';
    class MailUtils{
    	// The param of mails
    	private $_mailname;
    	private $_mailemail;
    	private $_mailpassword;
        private $_mailrecipient;
        private $_mailhost;
        private $_mail_body;
        private $_mailsubject;
        private $_mail;
        
        /**
         * @param string $recipient   The receieve client
         * @param string $mail_body   The mail body
         * @param string $subject     The subject
         * @param string $header      The mail header
         * @param string $name=null   The mail name default: linbin     
         * @param string $email       The mail email default: 1028332359@qq.com
         */
        public function __construct($recipient, $mail_body, $subject, $password, $name=null, $email=null, $host=null){
        	if(!isset($recipient) || !isset($mail_body) || !isset($subject) || !isset($password)){
        		die("MailUtils::construct  The recipient and mail body and subject and password must be exsist!!");
        	}
        	$this->_mailname = (isset($name)) ? $name : 'linbin';
        	$this->_mailemail = (isset($email)) ? $email : '1028332359@qq.com';
        	$this->_mailhost = (isset($host)) ? $host : 'smtp.qq.com';
        	$this->_mailrecipient = $recipient;
        	$this->_mail_body = $mail_body;
        	$this->_mailsubject = $subject;
        	$this->_mailpassword = $password;
        	
        	$this->_mail = new PHPMailer();
        	$this->_mail->IsSMTP();                #声明邮件协议
        	$this->_mail->Host = $this->_mailhost;     #发送邮件的服务器
        	$this->_mail->SMTPAuth = true;
        	$this->_mail->Username = $this->_mailemail;
        	$this->_mail->Password = $this->_mailpassword;
        	$this->_mail->From = $this->_mailemail;
        	$this->_mail->FromName = $this->_mailname;
        	$this->_mail->AddAddress("$this->_mailrecipient", "");
        	$this->_mail->CharSet = "UTF-8";
        	$this->_mail->Encoding = "base64";
        	$this->_mail->IsHTML(true);
        	$this->_mail->Subject = $this->_mailsubject;
        	$this->_mail->Body = $this->_mail_body;
        	$this->_mail->AltBody = "text/html";
        }
        
        /**
         * The module to send email
         * @return boolean
         */
        public function sendemail(){
        	return $this->_mail->Send();
        }
    }
?>