<?php 
   /**
    * The table teach_body
    * @author lin bin
    */
   class Teach_body extends Zend_Db_Table_Abstract {
   	  
   	   protected $_name = 'teach_body';
       protected $_referenceMap = array(
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