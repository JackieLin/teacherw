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
   }
?>