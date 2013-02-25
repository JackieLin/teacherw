<?php
  /**
   * @author linbin
   * an util class that can solve all image problem
   */
  require_once 'Zend/Session/Namespace.php'; 
  class ImageUtils{
  	  var $_code_session;
  	  var $_font_path;
  	  var $_image_dir;
  	  
      function generateCheckCode(){
      	  $captcha = new Zend_Captcha_Image(array('font'=>$this->_font_path,  //字体文件路径	
		    			'fontsize'=>24,  //字号
		    			'imgdir'=>$this->_image_dir,  //验证码图片存放位置	
		    			'session'=>$this->_code_session,  //验证码session值	
		    			'width'=>120,  //图片宽
		    			'height'=>40,      //图片高
		    			'wordlen'=>5 )
		    	  );  //字母数
      	  $captcha->setDotNoiseLevel('5')->setLineNoiseLevel('5');
      	  $captcha->getGcFreq(1); //设置删除生成的旧的验证码图片的随机几率
      	  $captcha->generate(); //生成图片
      	  $codes = array(
      	  		   'session' => $this->_code_session,
      	  		   'captcha' => $captcha
      	  		);
      	  return $codes;
      }
      
      /**
       * @param string $font_path  The font_path
       * @param string $code_session
       * @param string $image_dir
       */
      function __construct($font_path, $code_session, $image_dir){
      	  if(!$font_path || !$code_session || !$image_dir){
      	  	  die("the font_path or the font_path or image_dir is not exites!!");
      	  }
      	  $this->_code_session = new Zend_Session_Namespace($code_session);
      	  $this->_font_path = $font_path;
      	  $this->_image_dir = $image_dir;
      }
  }
?>