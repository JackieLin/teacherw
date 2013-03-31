<?php
   /**
    * The table Teachno_content
    * @author linbin
    */ 
   class Teachno_content extends Zend_Db_Table_Abstract {
   	   protected $_name = 'teachno_content';
   	   
   	   protected $_referenceMap = array(
   	      
   	   		'type' => array(
   	      		'columns' => array('type_id'),
   	      		'refTableClass' => 'Teachno_type',
   	      		'refColumns' => array('id'),
   	      		'onDelete' => self::CASCADE,
   	      		'onUpdate' => self::RESTRICT
   	       )		
   	   );
   }
?>