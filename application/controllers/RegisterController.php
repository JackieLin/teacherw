<?php
   /**
    * The controller to manager register
    * @author linbin
    */
   require_once 'BaseController.php';
   require_once APPLICATION_PATH.'/utils/DatabaseUtils.php';
   require_once APPLICATION_PATH.'/models/User.php';
   require_once APPLICATION_PATH.'/models/RoleUser.php';
   require_once APPLICATION_PATH.'/utils/LogUtils.php';
   require_once APPLICATION_PATH.'/utils/MailUtils.php';
   
   class RegisterController extends BaseController{
        
   	    private $_registerRequest;
   	    private $_databaseutils;
   	    
   	    public function init(){
   	    	parent::init();
            $this->_registerRequest = $this->getRequest();	
            $this->_databaseutils = new DatabaseUtils();
   	    }
        	
        public function registerAction(){
        	
        }
        /**
         * The register commit action
         */
        public function registercommAction(){
        	$number = $this->_registerRequest->getParam("number");
        	$flag = $this->checkUserByNumber($number);
        	if($flag === true){
        		echo 'userexsist';
        		parent::unsetAll(array($number, $flag));
        		$this->_helper->viewRenderer->setNoRender(true);
        		return;
        	}
        	$name = $this->_registerRequest->getParam("name");
        	$pass = md5($this->_registerRequest->getParam('password'));
        	$nickname = $this->_registerRequest->getParam("nickname");
        	$email = $this->_registerRequest->getParam("email");
        	
        	// 插入用户到数据库
        	$condition = array(
        	    'nickname' => $nickname,
        		'name' => $name,
        		'number' => $number,
        		'password' => $pass,
        		'email' => $email
        	);
        	
        	$user = new User();
        	$id = $this->_databaseutils->insert($user, $condition);
        	if($id >= 1){
        		// send email
        		$state = $this->sendCheckEmail($nickname, $email, $number);
        		parent::unsetAll(array($number, $flag, $name, $pass, $nickname, $condition, $user));
        		$result = ($state) ? 'success' : 'senderror';
        		echo $result;
        		$this->_helper->viewRenderer->setNoRender(true);
        	    return;
        	}
        	
        }
        
        public function checkAction(){
        	$number = $this->_registerRequest->getParam("number");
        	$checkcode = $this->_registerRequest->getParam('checkcode');
        	if(md5($number) !== $checkcode){
        		$this->view->assign("result",'验证链接有误,请重新输入');
        		return;
        	}
        	
        	$user = new User();
        	$row = $this->_databaseutils->fetchData($user, $this->db, array('number' => $number));
        	if(!isset($row)){
        		$this->view->assign("result",'用户不存在,请重新注册');
        		return;
        	}
        	$id = intval($row->id);
        	parent::unsetAll(array($row, $user));
        	
        	$roleuser = new RoleUser();
        	$datas = array(
        	     'role_id' => 1,
        		 'user_id' => $id
        	);
        	$num = $this->_databaseutils->insert($roleuser, $datas);
            if($num === false){
            	$this->view->assign("result", "数据库插入错误");
            } else{
            	$this->view->assign("result", "success");
            }
        }
        
        /**
         * To send email to the target email
         * @param string $name
         * @param string $email
         * @param string $number
         */
        public function sendCheckEmail($nickname, $email, $number){
        	 if(!isset($nickname) || !isset($email) || !isset($number)){
        	 	 die("RegisterController::sendCheckEmail the name and email and number must be exsist!!");
        	 }
        	 // send mail
        	 $recipient = "$email";
        	 $subject = "用户验证";
        	 $numberMd5 = md5($number);
        	 echo($numberMd5);
        	 $mail_body = "<html><head>
        	                  <meta http-equiv='Content-Language'>   
                              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        	 		        <body>
        	 		           <h3 style='font-weight:bold;'>亲爱的$nickname:  </h3>
        	 		           <p>请点击下方链接以完成注册: </p>
        	 		           <a href='http://teacherw.sinaapp.com/register/check?number=$number&checkcode=$numberMd5'>
        	 		              http://teacherw.sinaapp.com/register/check?number=$number&checkcode=$numberMd5
        	 		           </a>
        	 		        </body>  
        	               </head></html>";
        	 
        	 $mail = new MailUtils($recipient, $mail_body, $subject, 'dashilinbin90621');
        	 $state = $mail->sendemail();
             parent::unsetAll(array($recipient, $subject, $numberMd5, $mail_body, $mail));
        	 return $state;
        }
        /**
         * To check the user is exsist or not by number
         * @param string $number
         */
        public function checkUserByNumber($number){
        	 if(!isset($number)){
        	 	 die("RegisterController::checkUserByNumber The user number must be exsist!!");
        	 }
        	 $user = new User();
        	 $datas = array('number' => $number);
        	 $row = $this->_databaseutils->fetchData($user, $this->db, $datas);
        	 
        	 $flag = isset($row);
        	 
        	 parent::unsetAll(array($user,$datas,$row));
        	 
        	 return $flag;
        }
   }
?>