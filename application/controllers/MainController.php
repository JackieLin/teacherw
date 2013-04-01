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
require_once APPLICATION_PATH . '/models/Educate_type.php';
require_once APPLICATION_PATH . '/models/Educate_content.php';
require_once APPLICATION_PATH . '/models/Educate_body.php';
require_once APPLICATION_PATH . '/models/Teachno_type.php';
require_once APPLICATION_PATH . '/models/Teachno_content.php';
require_once APPLICATION_PATH . '/models/Teachno_body.php';

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
		
		// 所有模块都需要，先要取得教师权限
		$competenceids = $this->getUserCompetenceId($this->_user['id']);
		// 根据权限显示教学数据
		if($type === 'educate'){
			$educate_type = null;
			$educate_content = null;
			$educate_body = null;
			if(isset($competenceids)){
				$result = $this->fetchEducate($competenceids, $this->_user['id']);
			    // 赋值
			    $educate_type = count($result['type']) ? $result['type'] : null;
			    $educate_content = count($result['content']) ? $result['content'] : null;
			    $educate_body = count($result['body']) ? $result['body'] : null;
			}
			// 设置到前端界面
			$this->view->assign('educatetype', $educate_type);
			$this->view->assign('educatecontent', $educate_content);
			$this->view->assign('educatebody', $educate_body);
			
		}
		
		// 根据权限显示所有的内容
		// 定义数组对象
		if($type === 'teach'){
			$teach_type = null;
			$teach_content = null;
			$teach_subcontent = null;
			$teach_body = null;
			
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
		
		// 科研推广部分
		if ($type === 'teachnology'){
			$teachnotype = null;
			$teachnocontent = null;
			$teachnobody = null;
			
			if (isset($competenceids)) {
				$result = $this->fetchTeachno($competenceids, $this->_user['id']);
				$teachnotype = count($result['type']) ? $result['type'] : null;
				$teachnocontent = count($result['content']) ? $result['content'] : null;
				$teachnobody = count($result['body']) ? $result['body'] : null;
			}
			
			$this->view->assign("teachnotype", $teachnotype);
			$this->view->assign("teachnocontent", $teachnocontent);
			$this->view->assign("teachnobody", $teachnobody);
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
		$this->_helper->viewRenderer->setNoRender(true);
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
	 *  根据用户提交的内容修改数据库
	 */
	public function updateteachAction(){
		$name = $this->_pagerequest->getParam("name");
		$condition = $this->_pagerequest->getParam("condition");
		$content_id = $this->_pagerequest->getParam("content_id");
		if(!isset($name, $condition, $content_id)){
			die("MianController::updateteach The name and condition and content_id must be exsist!!");
		}
		 
		$teach_body = new Teach_body();
		$num = $this->_database->update($teach_body, $this->db, array('name' => $name, 'condition' => $condition),
				array('id' => $content_id));
		if(is_int($num)){
			echo "更新数据成功";
		} else{
			echo "更新数据失败";
		}
		
		parent::unsetAll(array($teach_body));
		$this->_helper->viewRenderer->setNoRender(true);
		return;
	}
	
	/**
	 * 将teach记录添加到数据库中
	 */
	public function addteachAction(){
		$name = $this->_pagerequest->getParam("name");
		$condition = $this->_pagerequest->getParam("condition");
		$content_id = $this->_pagerequest->getParam("content_id");
		$hassubparent = $this->_pagerequest->getParam("hassubparent");
		$user_id = $this->_pagerequest->getParam("user_id");
		if(!isset($name, $condition, $content_id, $hassubparent, $user_id)){
			die("MainController::addteachAction the params must be exsist!!");
		}
		$hassubparent = intval($hassubparent);
	    $teach_body = new Teach_body();
		$num = $this->_database->insert($teach_body, array('name' => $name, 'condition' => $condition, 
				       'year' => '2013', 'hassubparent' => $hassubparent, 'content_id' => $content_id,
				       'user_id' => $user_id));
		if(intval($num)){
			echo '插入数据成功';
		} else{
			echo '插入数据失败';
		}
		
		parent::unsetAll(array($teach_body));
		
		$this->_helper->viewRenderer->setNoRender(true);
		return;
	}
	
	/**
	 * 添加teachno到数据库
	 */
	public function addteachnoAction() {
		$log = new LogUtils('D:/Program Files/apache/logs/output.log');
		$name = $this->_pagerequest->getParam("name");
		$condition = $this->_pagerequest->getParam("condition");
		$content_id = $this->_pagerequest->getParam("content_id");
		$user_id = $this->_pagerequest->getParam("user_id");
		$user_id = intval($user_id);
		$content_id = intval($content_id);
		if (!isset($name, $condition, $content_id, $user_id)) {
			die("MainController::addteachnoAction the name and condition and content_id and user_id must be exsist!");
		}
		$teachnobody = new Teachno_body();
		$num = $this->_database->insert($teachnobody, array('name' => $name, 'condition' => $condition, 'year' => '2013',
				'content_id' => $content_id, 'user_id' => $user_id));
		if(intval($num)){
			echo '插入数据成功';
		} else{
			echo '插入数据失败';
		}
		
		parent::unsetAll(array($teachnobody));
		
		$this->_helper->viewRenderer->setNoRender(true);
		return;
	}
	
	/**
	 * 更新数据到数据库
	 */
	public function updateteachnoAction() {
		$name = $this->_pagerequest->getParam("name");
		$condition = $this->_pagerequest->getParam("condition");
		$content_id = $this->_pagerequest->getParam("content_id");
		if(!isset($name, $condition, $content_id)){
			die("MianController::updateteachno The name and condition and content_id must be exsist!!");
		}
			
		$teachnobody = new Teachno_body();
		$num = $this->_database->update($teachnobody, $this->db, array('name' => $name, 'condition' => $condition),
				array('id' => $content_id));
		if(is_int($num)){
			echo "更新数据成功";
		} else{
			echo "更新数据失败";
		}
		
		parent::unsetAll(array($teachnobody));
		$this->_helper->viewRenderer->setNoRender(true);
		return;
	}
	
	/**
	 * 添加或修改educate 的action
	 */
	public function addorupdateeduAction(){
		// get data
		$userid = $this->_pagerequest->getParam("user");
		$edutext = $this->_pagerequest->getParam('edutext');
		$textaction = $this->_pagerequest->getParam('textaction');
		$educatese = $this->_pagerequest->getParam("educatese");
		$eduelse = $this->_pagerequest->getParam("eduelse");
		$userid = intval($userid);
		$alldata = null;
		$result = null;
		$educatetype = null;
		$educatecontent = null;
		$educatebody = null;
		$educatebodyobj = new Educate_body();
		// 标志变量
		$tempids = array();
		$tempflags = array();
		$tempedu = null;
		$length = null;
		$row = null;
		$tempcontent = null;
		$tempbody = null;
		// unchangable
		$selectlength = 0;
		$tmp = null;
		
		// To split the textaction
		if(is_array($textaction)){
			foreach ($textaction as $text){
				$tempflags[] = strtok($text, " ");
				$tempids[] = strtok(" ");
			}
			
			// change the array to ids
			for($i = 0, $length = count($edutext); $i < $length; $i++){
				$tempedu[$tempids[$i]] = array('text' => $edutext[$i], 'action' => $tempflags[$i]);
			}
			
			$edutext = $tempedu;
		}
	    // 数据库取出所有数据
	    $compeids = $this->getUserCompetenceId($userid);
	    if(isset($compeids)){
	    	$result = $this->fetchEducate($compeids, $userid);
	    }
	    $educatetype = $result['type'];
	    $educatecontent = $result['content'];
	    $educatebody = (count($result['body'])) ? $result['body'] : null;
	    // 处理edutext
		foreach ($educatetype as $type){
		     $temptypeshow = $type['showtype'];
		     $temptypeid = $type['id'];
		     if($temptypeshow === 'text'){
		     	$tempedu = $edutext[$temptypeid];
		     	
		     	if(isset($tempedu)){
		     		// follow the action to manager db
		     		if($tempedu['action'] === 'add' && $tempedu['text'] !== ""){
		     			// add data to database
		     			$row = $this->_database->insert($educatebodyobj, array('content' => $tempedu['text'], 'user_id' => $userid, 
		     					'content_id' => $temptypeid, 'hasparent' => 0));
		     			if(!isset($row)){
		     				die("Add text is error, please try again");
		     			}
		     			
		     		} else if($tempedu['action'] === 'up_dele'){
		     			$tempbody = $this->getDataByCondition($educatebody, array('content_id' => $temptypeid, 'user_id' => $userid, 'hasparent' => '0'));
		     		    // delete
		     		    if ($tempedu['text'] === "" && count($tempbody)){
		     		    	$row = $this->_database->delete($educatebodyobj, $this->db, array('id' => $tempbody[0]['id']));
		     		    	if(!isset($row)){
		     		    		die("delete text is error, please try again");
		     		    	}
		     		    }
		     		   // update
		     		   if ($tempedu['text'] !== "" && count($tempbody)) {
		     		   	   $row = $this->_database->update($educatebodyobj, $this->db, array('content' => $tempedu['text']), 
		     		   	   		array('id' => $tempbody[0]['id'], 'user_id' => $userid, 'hasparent' => 0));
		     		   	   if(!isset($row)){
		     		   	   	   die("update text is error, please try again");
		     		   	   }
		     		   }
		     		}
		     	}
		     } else if ($temptypeshow === 'select') {
		     	   $tempcontent = $this->getDataByCondition($educatecontent, array('type_id' => $temptypeid));
		     	   foreach ($tempcontent as $key => $value) {
			     	   	$tmp = null;
			     	   	$bodyid = $value['id'];
			     	   	$tempbody = $this->getDataByCondition($educatebody, array('content_id' => $value['id'], 'user_id' => $userid, 
			     	   			'hasparent' => '1'));
			     	   	foreach ($educatese as $else) {
			     	   		if ($else === $value['content']){
			     	   			$tmp = $else;
			     	   			break;
			     	   		}
			     	   	}
			     	   	
			     	   	// add
			     	   	if (isset($tmp) && !count($tempbody)) {
			     	   		// insert
			     	   		$row = $this->_database->insert($educatebodyobj, array('content' => $tmp, 'user_id' => $userid,
			     	   				'content_id' => $value['id'], 'hasparent' => 1));
			     	   		if(!isset($row)){
			     	   			die("Add select is error, please try again");
			     	   		}
			     	   	}
			     	   	// update
			     	   	if (isset($tmp) && count($tempbody)) {
			     	   		$row = $this->_database->update($educatebodyobj, $this->db, array('content' => $tmp),
			     	   				array('user_id' => $userid, 'content_id' => $bodyid, 'hasparent' => 1));
			     	   		if(!isset($row)){
			     	   			die("update select is error, please try again");
			     	   		}
			     	   	}
			     	   	// delete
			     	   	if (!isset($tmp) && count($tempbody)) {
			     	   		$row = $this->_database->delete($educatebodyobj, $this->db, array('id' => $tempbody[0]['id']));
			     	   		if(!isset($row)){
			     	   			die("delete select is error, please try again");
			     	   		}
			     	   	}
		     	   }
		     } else {
		     	  $tempcontent = $this->getDataByCondition($educatecontent, array('type_id' => $temptypeid));
// 		     	  $tempbody = $this->getDataByCondition($educatebody, array());
                  foreach ($tempcontent as $key => $value) {
                  	   $tmp = null;
                  	   $bodyid = $value['id'];
                  	   $tempbody = $this->getDataByCondition($educatebody, array('content_id' => $bodyid, 'user_id' => $userid,
                  	   		'hasparent' => "1"));
                  	   foreach ($eduelse as $else) {
                  	   	   if ($else === $value['content']){
                  	   	   	    $tmp = $else;
                  	   	   	    break;
                  	   	   }
                  	   }
                  	   
                  	   // add
                  	   if (isset($tmp) && !count($tempbody)) {
                  	   	   $row = $this->_database->insert($educatebodyobj, array('content' => $tmp, 'content_id' => $bodyid, 
                  	   	   		'user_id' => $userid, 'hasparent' => 1));
                  	   	   if(!isset($row)){
                  	   	   	die("Add else is error, please try again");
                  	   	   }
                  	   }
                  	   // update
                  	   if (isset($tmp) && count($tempbody)) {
                  	   	   	 $row = $this->_database->update($educatebodyobj, $this->db, array('content' => $tmp),
                  	   	   			array('user_id' => $userid, 'content_id' => $bodyid, 'hasparent' => 1));
                  	   	   	 if(!isset($row)){
                  	   	   	 	die("update else is error, please try again");
                  	   	   	 }
                  	   }
                  	   // delete
                  	   if (!isset($tmp) && count($tempbody)) {
                  	   	   	 $row = $this->_database->delete($educatebodyobj, $this->db, array('id' => $tempbody[0]['id']));
                  	   	   	 if(!isset($row)){
                  	   	   	 	die("delete else is error, please try again");
                  	   	   	 }
                  	   }
                  }
		     }
		}
	    $this->redirect('main.html?type=educate');
	}
	
	/**
	 * get obj data meet the condition
	 * @param array(0 => array(), ...) $obj
	 * @param array $condition  {'****' => '****', ....}
	 * @return array $result The result that meet the condition
	 */
	public function getDataByCondition($obj, $condition){
		if(!isset($condition)){
			die('MainController::getDataByCondition The condition must be exsist!!');
		}
		$result = array();
		if(!isset($obj))
			return $result;
		
		$flag = false;
		$temp = null;
		
		foreach ($obj as $objvalue){
		     foreach ($condition as $key => $value){
		     	 if ($objvalue[$key] != $value) {
		     	 	$flag = true;
		     	 	break;
		     	 }
		     }
		     if (!$flag){
		     	$result[] = $objvalue;
		     	continue;
		     }
		     $flag = false;
		}
		return $result;
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
	 * 取出所有educate type以及educate content表的所有数据
	 * @param array $ids  the user competence
	 * @param int $userid
	 * @return array 
	 * {
	 *    type : {0: array(id=>...), ...}
	 *    content : {0 : array(id=>...), ...}
	 * }
	 */
	public function fetchEducate($ids, $userid){
		if(!isset($ids, $userid)){
			die("MainController::fetchEducate  The competence id and user id must be exsist!!");
		}
		
		$result = array();
		// 定義educate type
        $educatetype = array();
        // 定義educate content
        $educatecontent = array();
        // 定义educate body
        $educatebody = array();
        
        $educateset = null;
		$edutypeobj = new Educate_type();
		$edubodyobj = new Educate_body();
		$lenght = null;
		$sublenght = null;
		$tempeducate = null;
		$subrow = null;
		$tempcontent = array();
		
		foreach ($ids as $id){
			$educateset = $this->_database->fetchData($edutypeobj, $this->db, array('competence_id' => $id), 'all');
			if($educateset === null) continue;
			// 得到最终结果
			for($i = 0, $lenght = $educateset->count(); $i < $lenght; $i++){
				$tempeducate = $educateset[$i];
				// 轉換對象為數組
				foreach ($tempeducate as $key => $value){
					$educatetype[$i][$key] = $value;
				}
				
				if($tempeducate['showtype'] !== 'text'){
					// 取出值
					$subrow = $this->_database->findDependentRow($tempeducate, 'Educate_content', 'educatetype');
					
					// 取出值并填在content数组中
					for($j = 0, $sublenght = $subrow->count(); $j < $sublenght; $j++){
						$tempeducate = $subrow[$j];
						foreach ($tempeducate as $key => $value){
							$tempcontent[$key] = $value;
						}
						$educatecontent[] = $tempcontent;
					}
				}
			}
		}
		
		// 取出所有的educate body
		$educateset = $this->_database->fetchData($edubodyobj, $this->db, array('user_id' => $userid), 'all');
		$educatebody = $this->_database->changeToArray($educateset);
		
	    $result['type'] = $educatetype;
	    $result['content'] = $educatecontent;
	    $result['body'] = $educatebody;
	    
	    parent::unsetAll(array($educateset, $edutypeobj, $edubodyobj, $lenght, $tempcontent, $tempeducate, $subrow));
	    return $result;
	}
	
	/**
	 *  get teachno message by cmpetence id and user id
	 *  @param array $ids 用户权限的id
	 *  @param string $userid 用户id
	 */
	public function fetchTeachno($ids, $userid){
	    if(!isset($ids, $userid)){
	    	die("MainController::fetchTeachno The competence ids and user id must be exsist!!");
	    }
	    $result = array();
	    $teachnotypearr = array();
	    $teachnocontentarr = array();
	    $teachnobodyarr = array();
	    
	    $teachnoset = null;
	    $length = null;
	    $sublength = null;
	    $tempteachno = null;
	    $tempteachnocon = array();
	    $teachbodyset = null;
	    $subrow = null;
	    $teachnotype = new Teachno_type();
	    $teachnobody = new Teachno_body();
	    $log = new LogUtils('D:/Program Files/apache/logs/output.log');
	    foreach ($ids as $id){
	    	$teachnoset = $this->_database->fetchData($teachnotype, $this->db, array('competence_id' => $id), 'all');
	        
	        if(isset($teachnoset)){
	        	for($i = 0, $length = $teachnoset->count(); $i < $length; $i++){
	        		// 对于每一个teachno,获取teachno_content
	        		$tempteachno = $teachnoset[$i];
	        		// 转换对象为数组
	        		foreach ($tempteachno as $key => $value){
	        			$teachnotypearr[$i][$key] = $value;
	        		}
	        		
	        		$subrow = $this->_database->findDependentRow($tempteachno, 'Teachno_content', 'type');
	        		
	        		if(isset($subrow)){
	        			$tempteachnocon = array();
		        	    for($j = 0, $sublength = $subrow->count(); $j < $sublength; $j++){
		        	    	$tempteachno = $subrow[$j];
		        	    	foreach ($tempteachno as $key => $value){
		        	    		$tempteachnocon[$key] = $value;
		        	    	}
		        	    	$teachnocontentarr[] = $tempteachnocon;
		        	    }
	        		}
	        	}
	        }
	    }
        
	    // 取出所有的teachno body
	    $teachnobody = $this->_database->fetchData($teachnobody, $this->db, array('user_id' => $userid), 'all');
	    $teachnobodyarr = $this->_database->changeToArray($teachnobody);
	    
	    $result['type'] = $teachnotypearr;
	    $result['content'] = $teachnocontentarr;
	    $result['body'] = $teachnobodyarr;
	    
	    parent::unsetAll(array($teachbodyset, $teachnoset, $tempteachno, $tempteachnocon, $subrow, $teachnotype, $teachnobody));
	    return $result;
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