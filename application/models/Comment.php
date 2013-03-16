<?php
   /**
    * The comment table
    * @author root
    */ 
   class Comment extends Zend_Db_Table_Abstract{
   	   protected $_name = 'comment';
   	   /**
   	    * @var array the reference map
   	    */
   	   protected $_referenceMap = array(
   	        news => array(
   	            'columns' => array('new_id'),
   	        	'refTableClass' => 'News',
   	        	'refColumns' => array('id'),
   	        	'onDelete' => self::CASCADE,
   	        	'onUpdate' => self::RESTRICT
   	        )
   	   );
   }
?>