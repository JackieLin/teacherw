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
   	   private $_pageNum;
   	   
   	   public function init(){
   	   	   // init
   	   	   parent::init();
   	   	   $this->_userSession = new Zend_Session_Namespace('user');
   	       $this->_user = $this->_userSession->user;
   	       $this->_roles = $this->_userSession->roleNames;
   	       $this->_pageNum = $this->_userSession->page;
   	       $this->_database = new DatabaseUtils();
   	       $this->_pagerequest = $this->getRequest();
   	   }
   	   
   	   public function mainAction(){
   	   	
   	   	   // 验证用户是否登录
   	   	   if(!isset($this->_user)){
   	   	   	  $this->_forward('index','index',null,array('login'=>'nologin'));
   	   	   }
   	   	   if(!isset($this->_pageNum)){
   	   	       $this->_pageNum = $this->_database->getTableCount("news", $this->db);
   	   	       $this->_userSession->page = $this->_pageNum;
   	   	   }
   	   	   $page = $this->_pagerequest->getParam("page");
   	   	   if(!isset($page)){
   	   	   	   $page = 1;
   	   	   }
   	   	   $page = intval($page);
   	   	   
   	       // To show news
//    	   	   $news = new News();
//    	   	   $condition = array(
//    	   	   		'order' => 'time DESC',
//    	   	   		'count' => '5'
//    	   	   );
   	   	   
   	   	   $newpage = $this->fetchNewsByPage($page);
   	   	   
   	   	   // To show links
   	   	   $links = new Links();
   	   	   $linkDate = $this->_database->fetchData($links, $this->db, array(),'all');
   	       $linkset = $this->_database->changeToArray($linkDate);
   	       
   	   	   $this->view->assign('user',$this->_user);
   	   	   $this->view->assign('news',$newpage);
   	   	   $this->view->assign('links',$linkset);
   	   	   
   	   	   // No pre news
   	   	   if($page * 5 >= $this->_pageNum && $page * 5 < $this->_pageNum + 5){
   	   	   		$this->view->assign("display",'none');
   	   	   } else{
   	   	   	    $this->view->assign("display","block");
   	   	   }
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
   	   	   
   	   	   $encode = json_encode($newset);
   	   	   if($pageNum * 5 >= $this->_pageNum && $pageNum * 5 < $this->_pageNum + 5){
   	   	   	   $encode .= "nodisplay";
   	   	   }
   	   	   echo $encode;
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