<?php
   require_once APPLICATION_PATH.'/utils/DatabaseUtils.php';
   require_once APPLICATION_PATH.'/utils/LogUtils.php';
   require_once 'BaseController.php';
   require_once APPLICATION_PATH.'/models/Links.php';
   require_once APPLICATION_PATH.'/models/News.php';
   
   class MainController extends BaseController{
   	   /**
   	    * @var object $_userSession The user session and roles
   	    */
   	   private $_userSession;
   	   private $_user;
   	   private $_roles;
   	   private $_database;
   	   private $_pagerequest;
   	   
   	   public function init(){
   	   	   // init
   	   	   parent::init();
   	   	   $this->_userSession = new Zend_Session_Namespace('user');
   	       $this->_user = $this->_userSession->user;
   	       $this->_roles = $this->_userSession->roleNames;
   	       $this->_database = new DatabaseUtils();
   	       $this->_pagerequest = $this->getRequest();
   	   }
   	   
   	   public function mainAction(){
   	   	
   	   	   // 验证用户是否登录
   	   	   if(!isset($this->_user)){
   	   	   	  $this->_forward('index','index',null,array('login'=>'nologin'));
   	   	   }
   	       // To show news
   	   	   $news = new News();
   	   	   $condition = array(
   	   	   		'order' => 'time DESC',
   	   	   		'count' => '5'
   	   	   );
   	   	   
   	   	   $newpage = $this->fetchNewsByPage(1);
   	   	   
   	   	   // To show links
   	   	   $links = new Links();
   	   	   $linkDate = $this->_database->fetchData($links, $this->db, array(),'all');
   	       $linkset = $this->_database->changeToArray($linkDate);
   	       
   	   	   $this->view->assign('user',$this->_user);
   	   	   $this->view->assign('news',$newpage);
   	   	   $this->view->assign('links',$linkset);
   	   }
   	   
   	   /**
   	    * 分页显示结果
   	    */
   	   public function pageAction(){
   	   	   $pageNum = $this->_pagerequest->getParam('page');
   	   	   if(!isset($pageNum)){
   	   	   	  die("MainController::pageAction  The page number should be exsist!!");
   	   	   }
   	   	   
   	   	   $newset = $this->fetchNewsByPage(intval($pageNum));
   	   	   echo json_encode($newset);
   	   	   $this->_helper->viewRenderer->setNoRender(true);
   	   }
   	   
   	   /**
   	    * To fetch news with page num
   	    * @param int $page
   	    */
   	   public function fetchNewsByPage($page){
	   	   	$news = new News();
	   	   	$condition = array(
	   	   			'order' => 'time DESC',
	   	   			'count' => '5'
	   	   	);
	   	   	return $this->fetchNews($news, $this->db, $condition,$page);
   	   }
   	   
   	   /**
   	    * The function fetch all news by page
   	    * @param object $table                  The table choose
   	    * @param resource $db                   The database resource
   	    * @param array $datas
   	    * @param int $page                      The page number
   	    * @return array $news                   The news array          
   	    */
   	   public function fetchNews($table,$db,$datas=null,$page=null){
   	   	   if(!isset($table) || !isset($db)){
   	   	   	    die("MainController::fetchNews  The table and db must be exites!!");
   	   	   }
   	   	   if(isset($page)){
   	   	   	   if(!isset($datas)){
   	   	   	   	   $datas = array();
   	   	   	   }
   	   	   	   $datas['offset'] = ($page - 1) * 5;
   	   	   }
   	   	   
   	   	   $rowdata = $this->_database->fetchData($table, $db, $datas,'all');
   	   	   
   	   	   $newpage = $this->_database->changeToArray($rowdata);
   	   	   return $newpage;
   	   }
   }
?>