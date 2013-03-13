<?php
   require_once 'Zend/Db.php';
   class BaseController extends Zend_Controller_Action{
   	  /**
   	   * 
   	   * @var resource the mysql connect
   	   */
   	  protected $db;
   	  
   	  // The location of config file
   	  protected $url;
   	  
   	  // The config object of database
   	  protected $dbconfig;
   	  
   	  /**
   	   * The init function
   	   * @see Zend_Controller_Action::init()
   	   */
   	  public function init(){
   	     $this->url = constant("APPLICATION_PATH").DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini';
   	     $this->dbconfig = new Zend_Config_Ini($this->url,"mysql");
   	     // instance the database link
   	     $this->db = Zend_Db::factory($this->dbconfig->db);
   	     $this->db->query("SET NAMES UTF8");
   	     require_once 'Zend/Db/Table.php';
   	     Zend_Db_Table::setDefaultAdapter($this->db);
   	  }
   	  
   	  /**
   	   * 从application.ini中取出对应属性的参数
   	   * @param string $attr
   	   * @param string $param
   	   * @return string
   	   */
   	  public function getIniParam($attr, $param){
   	  	 if(!isset($this->url)){
   	  	 	$this->url = constant("APPLICATION_PATH").DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini';
   	  	 }
   	  	 $config = new Zend_Config_Ini($this->url, $attr);
   	  	 $config = $config->toArray();
   	  	 return $config[$param];
   	  }
   	  
   	  /**
   	   * To unset all the objects
   	   * @param array $objs  The array of object that should be unset
   	   */
   	  public function unsetAll($objs){
   	  	   if(!isset($objs)){
   	  	   	    die("BaseController::unsetAll The objects param must be exsist!!");
   	  	   }
   	  	   foreach ($objs as $value){
   	  	   	   unset($value);
   	  	   }
   	  }
   }
?>