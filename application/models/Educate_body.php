<?php 
   /**
    * The educate_body table
    * @author linbin
    */
   class Educate_body extends Zend_Db_Table_Abstract {
   	    protected $_name = 'educate_body';
   	    
   	    protected $_referenceMap = array(
   	    	'user' => array(
   	    			'columns' => array('user_id'),
   	    			'refTableClass' => 'User',
   	    			'refColumns' => array('id'),
   	    			'onDelete' => self::CASCADE,
   	    			'onUpdate' => self::RESTRICT
   	    		),
   	    	'content' => array(
   	    		    'columns' => array('content_id'),
   	    			'refTableClass' => 'Educate_content',
   	    			'refColumns' => array('id'),
   	    			'onDelete' => self::CASCADE,
   	    			'onUpdate' => self::RESTRICT	
   	    		)
   	    );
   }
?>