<?php
   /**
    * The table teachno_body
    * @author linbin
    */ 
   class Teachno_body extends Zend_Db_Table_Abstract {
   	   protected $_name = "teachno_body";
   	   
   	   protected $_referenceMap = array(
   	      'content' => array(
   	      		'columns' => array('content_id'),
   	      		'refTableClass' => 'Teachno_content',
   	      		'refColumns' => array('id'),
   	      		'onDelete' => self::CASCADE,
   	      		'onUpdate' => self::RESTRICT
   	      ), 
   	   	  'user' => array(
   	    			'columns' => array('user_id'),
   	    			'refTableClass' => 'User',
   	    			'refColumns' => array('id'),
   	    			'onDelete' => self::CASCADE,
   	    			'onUpdate' => self::RESTRICT
   	    		)		
   	   );
   }
?>