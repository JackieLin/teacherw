<?php 
   /**
    * The table news
    * @author root
    */
   class News extends Zend_Db_Table_Abstract{
   	    
   	    protected $_name = 'news';
   	    protected $_dependentTables = array('Comment');
   }
?>