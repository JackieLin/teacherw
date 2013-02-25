<?php

require_once APPLICATION_PATH.'/utils/ImageUtils.php';
class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->image_generate();
    }

    public function codeAction(){
    	$this->image_generate();
    	echo $this->view->ImgDir.$this->view->captchaId;
        $this->_helper->viewRenderer->setNoRender(true);
    	
    }

    public function image_generate(){
    	$im = new ImageUtils(APPLICATION_PATH.'/utils/simsun.ttf', 'checkcode', './image/code/');
    	/**
    	 codes: 0 session
    	 1 captcha
    	*/
    	$codes = $im->generateCheckCode();
    	
    	$this->codeSession = $codes['session'];
    	$captcha = $codes['captcha'];
    	
    	$this->view->ImgDir = $captcha->getImgDir();
    	$this->view->captchaId = $captcha->getId(); //获取文件名，md5编码
    	$this->codeSession->code=$captcha->getWord(); //获取当前生成的验证字符串
    }
}

