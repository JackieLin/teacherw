<?php
require_once APPLICATION_PATH . '/utils/DatabaseUtils.php';
require_once APPLICATION_PATH . '/utils/LogUtils.php';
require_once 'BaseController.php';
require_once APPLICATION_PATH . '/models/Links.php';
require_once APPLICATION_PATH . '/models/News.php';
require_once APPLICATION_PATH . '/models/Comment.php';
require_once APPLICATION_PATH . '/models/Navigation.php';
require_once APPLICATION_PATH . '/utils/FileUploadUtils.php';
require_once APPLICATION_PATH . '/models/User.php';
require_once APPLICATION_PATH . '/models/CompetenceRole.php';
require_once APPLICATION_PATH . '/models/Competence.php';
require_once APPLICATION_PATH . '/models/Teach_type.php';
require_once APPLICATION_PATH . '/models/Teach_content.php';
require_once APPLICATION_PATH . '/models/Teach_subcontent.php';
require_once APPLICATION_PATH . '/models/Teach_body.php';

class MainController extends BaseController {
	/**
	 *
	 * @var object $_userSession The user session and roles
	 */
	private $_userSession;
	private $_user;
	private $_roles;
	private $_database;
	private $_pagerequest;
	private $_pageNum;
	public function init() {
		// init
		parent::init ();
		$this->_userSession = new Zend_Session_Namespace ( 'user' );
		$this->_user = $this->_userSession->user;
		$this->_roles = $this->_userSession->roleNames;
		$this->_pageNum = $this->_userSession->page;
		$this->_database = new DatabaseUtils ();
		$this->_pagerequest = $this->getRequest ();
	}
	public function mainAction() {
		
		// 验证用户是否登录
		if (! isset ( $this->_user )) {
			$this->_forward('index', 'index', null, array('login' => 'nologin'));
		}
		if (! isset ( $this->_pageNum )) {
			$this->_pageNum = $this->_database->getTableCount ( "news", $this->db );
			$this->_userSession->page = $this->_pageNum;
		}
		$page = $this->_pagerequest->getParam ( "page" );
		if (! isset ( $page )) {
			$page = 1;
		}
		$page = intval ( $page );
		
		$newpage = $this->fetchNewsByPage ( $page );
		
		// 取得主页类型
		$type = $this->_pagerequest->getParam("type");
		// To show the navigation 
		$navs = new Navigation();
		$navigation = $this->_database->fetchData($navs, $this->db, array(), 'all');
		$navset = $this->_database->changeToArray($navigation);
		
		// To show links
		$links = new Links ();
		$linkDate = $this->_database->fetchData ( $links, $this->db, array (), 'all' );
		$linkset = $this->_database->changeToArray ( $linkDate );
		
		// 根据权限显示所有的内容
		// 定义数组对象
		if($type === 'teach'){
			$teach_type = null;
			$teach_content = null;
			$teach_subcontent = null;
			$teach_body = null;
			$competenceids = $this->getUserCompetenceId($this->_user['id']);
			if(isset($competenceids)) {
				$teach_type = $this->getTeachTypeById($competenceids);
			}
			if(isset($teach_type) && count($teach_type) !== 0){
				$teach_content = $this->getTeachcontentByType($teach_type, $competenceids);
			}
			if(isset($teach_content)){
				$teach_subcontent = $this->getSubContentByContent($teach_content, $competenceids);
			}
			if(isset($teach_subcontent)){
				$teach_body = $this->getTeachBodyById($teach_content, $teach_subcontent, $this->_user['id']);
			}
			// 传入到页面中
			$this->view->assign('teachtype', $teach_type);
			$this->view->assign('teachcontent', $teach_content);
			$this->view->assign('teachsubcontent', $teach_subcontent);
			$this->view->assign('teachbody', $teach_body);
		}
		
		
		$this->view->assign ( 'user', $this->_user );
		$this->view->assign ( 'news', $newpage );
		$this->view->assign ( 'links', $linkset );
		$this->view->assign ( 'navigation', $navset);
		
		// No pre news
		if ($page * 5 >= $this->_pageNum && $page * 5 < $this->_pageNum + 5) {
			$this->view->assign ( "display", 'none' );
		} else {
			$this->view->assign ( "display", "block" );
		}
		
		parent::unsetAll(array($newpage, $navs, $navigation, $navset, $links, $linkDate, $linkset));
	}
	
	/**
	 * 修改信息模块
	 */
	public function messageAction() {
		if (!isset($this->_user)) {
			$this->_forward('index', 'index', null, array('login' => 'nologin'));
		}
		$this->view->assign('user',$this->_user);
	}
	
	/**
	 * The commit action
	 */
	public function commitAction(){
		$living = null; $homeplace = null;
		$nickname = $this->_pagerequest->getParam("nickname");
        $name = $this->_pagerequest->getParam("name");
        $image = $this->_pagerequest->getParam('image');
        $gender = $this->_pagerequest->getParam("gender");
        $gender = ($gender === 'male') ? 0 : 1;
        $college = $this->_pagerequest->getParam("college");
        $post = $this->_pagerequest->getParam("post");
        $specialty = $this->_pagerequest->getParam("specialty");
        $tutorial = $this->_pagerequest->getParam("tutorial");
        $office = $this->_pagerequest->getParam("office");
        $contact = $this->_pagerequest->getParam("contact");
        $birthday = $this->_pagerequest->getParam("birthday");
        $live = $this->_pagerequest->getParam("live");
        $home = $this->_pagerequest->getParam("home");
        
        foreach ($live as $key => $value){
        	$living .= $value;
        }
        
        foreach ($home as $key => $value){
        	$homeplace .= $value;
        }
        
        // 图片上传
        if($image){
			$fileutils = new FileUploadUtils('image', 'tmp_name', parent::getIniParam('image', 'path').'upload/',
					 $nickname.".jpg");
			$mess = $fileutils->upload();
			
			if($mess === 'oversize'){
				$this->_redirect("register/check?result=oversize");
			} else if($mess === 'typeerror'){
				$this->_redirect("register/check?result=typeerror");
			} else if($mess === 'error'){
				$this->_redirect("register/check?result=error");
			}
        }
		// 修改数据
		$set = array(
		   'name' => $name,
		   'avater' => 'upload/'.$nickname.'.jpg',
		   'gender' => $gender,
		   'birthday' => $birthday,
		   'living' => $living,
		   'bornplace' => $homeplace,
		   'college' => $college,
		   'post' => $post,
		   'specialty' => $specialty,
		   'tutorial' => $tutorial,
		   'office' => $office,
		   'contact' => $contact,
		);
		
		$where = array(
		   'nickname' => $nickname
		);
		
		$user = new User();
		$this->_database->update($user, $this->db, $set, $where);
		$this->redirect('register/check?result=success');
	}
	
	/**
	 * 请求图片模块
	 */
	public function imageAction() {
		$imageconfig = new Zend_Config_Ini($this->url, "image");
		$imagefile = $this->_pagerequest->getParam ( 'path' );
		$imagepath = $imageconfig->path . $imagefile;
		$image = $this->getImage($imagepath);
		$this->_helper->viewRenderer->setNoRender(true);
		$this->getResponse()->setHeader("content-type", $image['mime']);
		echo $image['image'];
		parent::unsetAll(array($imageconfig, $image));
	}
	/**
	 * 分页显示结果
	 */
	public function pageAction() {
		$pageNum = $this->_pagerequest->getParam ( 'page' );
		if (! isset ( $pageNum )) {
			die ( "MainController::pageAction  The page number should be exsist!!" );
		}
		
		$newset = $this->fetchNewsByPage ( intval ( $pageNum ) );
		
		$encode = json_encode ( $newset );
		if ($pageNum * 5 >= $this->_pageNum && $pageNum * 5 < $this->_pageNum + 5) {
			$encode .= "nodisplay";
		}
		echo $encode;
		$this->_helper->viewRenderer->setNoRender ( true );
	}
	
	
	public function articleAction(){
		$id = $this->_pagerequest->getParam("id");
		$result = array();
		// 从数据库取出数据
		$new = new News();
		$resultset = $this->_database->fetchData($new, $this->db, array('id' => $id));
	    foreach ($resultset as $key => $value){
	    	$result[$key] = $value;
	    }
	    parent::unsetAll(array($resultset, $new));
	    $this->view->assign("article", $result);
	    // 取出对应的评论
	    $comment = new Comment();
	    $commentset = $this->_database->fetchData($comment, $this->db, array('new_id' => $id), 'all');
	    $commentresult = array();
	    
	    for($i = 0; $i < $commentset->count(); $i++){
	       	$temp = $commentset[$i];
	       	foreach ($temp as $key => $value){
	       		if($key === 'image' && (!isset($value) || $value === '')){
	       			$commentresult[$i][$key] = '暂无';
	       		} else{
	       			$commentresult[$i][$key] = $value;
	       		}
	       	}
	    }
	    $this->view->assign("comment", $commentresult);
	    $this->view->assign("id", $id);
	    $this->view->assign("image", $this->_user['avater']);
	    $this->view->assign("nickname", $this->_user['nickname']);
	    parent::unsetAll(array($comment, $commentresult, $commentset));
	}
	
	public function addcommentAction(){
	     $id = $this->_pagerequest->getParam("id");
	     $nickname = $this->_pagerequest->getParam("nickname");
	     $image = $this->_pagerequest->getParam("image");
	     $content = $this->_pagerequest->getParam("text");
         $time = date('Y-m-d H:i:s');
         
	     // insert the record
	     $comment = new Comment();
	     $datas = array('author' => $nickname, 'image' => $image, 'content' => $content,
	     		 'time' => $time, 'new_id' => $id);
	     $this->_database->insert($comment, $datas);
	     
	     // 更新数据库
	     $new = new News();
	     $set = array('commNum' => new Zend_Db_Expr('commNum + 1'));
	     $where = array('id' => $id);
	     $this->_database->update($new, $this->db, $set, $where);
	     
	     // 消除字段
	     parent::unsetAll(array($comment, $datas, $new, $set, $where));
	     $this->_redirect("article-$id.html");
	}
	
	/**
	 * @param string $path               The image path
	 * @return array
	 */
	public function getImage($path){
	    if(!isset($path)){
	    	die("MainControllor:: getImage The image path must be exsist!!");
	    }
	    require_once APPLICATION_PATH . '/utils/ImageDataUtils.php';
	    $imagedatautils = new ImageDataUtils ( $path );
	    $image = $imagedatautils->getImageData ();
	    $imagemime = $imagedatautils->getImageMime ();
	    return array('image' => $image, 'mime' => $imagemime);
	}
	/**
	 * To fetch news with page num
	 * 
	 * @param int $page        	
	 */
	public function fetchNewsByPage($page) {
		$news = new News ();
		$condition = array (
				'order' => 'time DESC',
				'count' => '5' 
		);
		return $this->fetchNews ( $news, $this->db, $condition, $page );
	}
	
	/**
	 * The function fetch all news by page
	 * 
	 * @param object $table
	 *        	The table choose
	 * @param resource $db
	 *        	The database resource
	 * @param array $datas        	
	 * @param int $page
	 *        	The page number
	 * @return array $news The news array
	 */
	public function fetchNews($table, $db, $datas = null, $page = null) {
		if (! isset ( $table ) || ! isset ( $db )) {
			die ( "MainController::fetchNews  The table and db must be exites!!" );
		}
		if (isset ( $page )) {
			if (! isset ( $datas )) {
				$datas = array ();
			}
			$datas ['offset'] = ($page - 1) * 5;
		}
		
		$rowdata = $this->_database->fetchData ( $table, $db, $datas, 'all' );
		
		$newpage = $this->_database->changeToArray ( $rowdata );
		return $newpage;
	}
	
	/**
	 * 用于获取特定用户的全部特权
	 * @param int $userid   用户id
	 * @return array        用户权限列表
	 */
	public function getUserCompetenceId($userid){
		if(!isset($userid)){
			die("MainController::getUserCompetence the user id should be exsist!!");
		}
		$competence = array();
		// 获取用户
		$user = new User();
		$userbyid = $this->_database->fetchData($user, $this->db, array('id' => $userid));
		
		$roles = $this->_database->findManyToManyRow($userbyid, 'Role', 'RoleUser', 'User', 'Role');
	    
		while ($roles){
			$role = $roles->current();
		    if($role === null){
		    	break;
		    }
			$roles->next();
			
			$temp = $this->_database->findManyToManyRow($role, 'Competence', 
					'CompetenceRole', 'role', 'competence');
			foreach ($temp as $value){
				$competence[] = $value['id'];
			}
		}
	    
		parent::unsetAll(array($user, $userbyid, $roles, $role, $temp));
		return $competence;
	}
	
	/**
	 * get teach type by competence id
	 * @param array $ids The id set
	 * @return array|null   the teach_type set {0: array(id=***, name=***), ***}
	 */
	public function getTeachTypeById($ids){
		if(!isset($ids) && !is_array($ids)){
			die("MainController::getTeachTypeById The competence id should be exsist!!");
		}
		$teacharr = array();
		$teach_type = new Teach_type();
		foreach ($ids as $id){
			$teachset = $this->_database->fetchData($teach_type, $this->db, 
					                   array('competence_id' => $id), 'all');
			$teachcollect = $this->_database->changeToArray($teachset);
			if(isset($teachcollect)){
			    $teacharr = array_merge($teacharr, $teachcollect);
			}
		}
		parent::unsetAll(array($teachset, $teachcollect));
		return $teacharr;
	}
	
	/**
	 * 根据teachType 和ids 返回对象
	 * @param array $teachtypes
	 * @param array $ids
	 * @return array {0: array(id=***, 'name'=>****, 'haschilden'=>***), ***}
	 */
	public function getTeachcontentByType($teachtypes, $ids){
		if(!isset($teachtypes) || !isset($ids)){
			die("MainController::getTeachcontentByType The teachtypes and ids must be exsist!!");
		}
		$teachcocntent = new Teach_content();
		$teachcontentarr = array();
		$teachcontentset = null;
		$temparr = null;
		for($i = 0; $i < count($teachtypes); $i++){
			// 遍历id号
		    $typeid = $teachtypes[$i]['id'];
		    foreach ($ids as $id){
		    	$teachcontentset = $this->_database->fetchData($teachcocntent, $this->db, 
		    			             array('competence_id' => $id, 'type_id' => $typeid), 'all');
		        $temparr = $this->_database->changeToArray($teachcontentset);
		        if(isset($temparr) && count($temparr) !== 0){
		        	if(!@is_array($teachcontentarr[$i])){
		        		$teachcontentarr[$i] = array();
		        	}
		        	$teachcontentarr[$i] = array_merge($teachcontentarr[$i], $temparr);
		        }
		    }
		}
		parent::unsetAll(array($teachtypes, $ids, $teachcocntent, $teachcontentset, $temparr));
		return $teachcontentarr;
	}
	
	/**
	 * 通过teachContent找到teachSubcontent
	 * @param array $teachContent
	 * @param array $ids
	 * @return array  array(0=>array(id=>...), ...)
	 */
	public function getSubContentByContent($teachContent, $ids){
		if(!isset($teachContent, $ids)){
			die("MainController::getSubContentByContent  The teacher content and ids must be exsist!!");
		}
		$teachSubContent = array();
		// 遍历teachcontent
		for($i = 0, $teachlength = count($teachContent); $i < $teachlength; $i++){
			$teachTemp = $teachContent[$i];
			if(isset($teachTemp)){
				for ($j = 0, $teachsublength = count($teachTemp); $j < $teachsublength; $j++){
					$teachsubtemp = $teachTemp[$j];
					// 判断是否有孩子
					$haschild = $teachsubtemp['haschildren'];
				    if($haschild === "1"){
				    	$contentid = $teachsubtemp['id'];
				    	$teachsubcontent = new Teach_subcontent();
				    	// 找到对应的subcontent
				    	foreach ($ids as $id){
				    		$tempsubcontent = $this->_database->fetchData($teachsubcontent, $this->db, array(
				    				'competence_id' => $id, 'content_id' => $contentid), 'all');
				    	    $temparr = $this->_database->changeToArray($tempsubcontent);
				    	    
				    	    for($k = 0, $temparrlength = count($temparr); $k < $temparrlength; $k++){
				    	    	$temp = $temparr[$k];
				    	    	$temp['parent'] = $j;
				    	    	$temp['root'] = $i;
				    	        $tempid = $temp['id']; 
				    	        $teachSubContent[] = $temp;
				    	    }
				    	}
				    }
				}
			}
		}
		return $teachSubContent;
	}
	
	/**
	 * 根据teachcontent, teachsubcontent以及userid过滤出数据
	 * @param array $teachcontent
	 * @param array $teachsubcontent
	 * @param int $userid
	 * @return array  array(0=>array(id=>***), ...);
	 */
	public function getTeachBodyById($teachcontent, $teachsubcontent, $userid){
		if(!isset($teachcontent, $teachsubcontent, $userid)){
			die("MainController::getTeachBodyById The teachcontent and subcontent and userid must be exsist!!");
		}
		
		$teachcontentids = array();
		$teachsubcontentids = array();
	    $teachbody = array();
	    $map = array();
	    $teach_body = new Teach_body();
	    
		// 遍历teachcontent
		for($i = 0, $teachlength = count($teachcontent); $i < $teachlength; $i++){
			$teachTemp = $teachcontent[$i];
			if(isset($teachTemp)){
				for ($j = 0, $teachsublength = count($teachTemp); $j < $teachsublength; $j++){
					$tempcontent = $teachTemp[$j];
					$teachcontentids[] = $tempcontent['id'];
				}
			}
		}
		
		for($i = 0, $teachlength = count($teachsubcontent); $i < $teachlength; $i++){
			$teachTemp = $teachsubcontent[$i];
			$teachsubcontentids[] = $teachTemp['id'];
		}
		
		// 合并数组
		for($j = 0, $teachsublength = count($teachsubcontentids); $j < $teachsublength; $j++){
			$teachTemp = $teachsubcontentids[$j];
			for($i = 0, $teachlength = count($teachcontentids); $i < $teachlength; $i++){
		        $tempcontent = $teachcontentids[$i];
		        if($teachTemp === $tempcontent) break;
			}
			if($i >= $teachlength) $teachcontentids[] = $teachTemp;
		}
		
		// 从数据库查找数据
		foreach ($teachcontentids as $value){
		   $teachTemp = $this->_database->fetchData($teach_body, $this->db, array('content_id' => $value,
		   		                'user_id' => $userid), 'all');	
		   $teacharr = $this->_database->changeToArray($teachTemp);
		   foreach ($teacharr as $value){
		   	  $teachbody[] = $value;
		   }
		}
		return $teachbody;
	}
}
?>