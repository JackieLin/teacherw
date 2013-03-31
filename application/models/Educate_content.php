<?php 
   /**
    * The education content table
    * @author linbin
    */
   class Educate_content extends Zend_Db_Table_Abstract {
   	   protected $_name = 'educate_content';
   	   
   	   protected $_dependentTables = array('Educate_body');
   	   
   	   protected $_referenceMap = array(
   	   		'educatetype' => array(
   	   				'columns' => array('type_id'),
   	   				'refTableClass' => 'Educate_type',
   	   				'refColumns' => array('id'),
   	   				'onDelete' => self::CASCADE,
   	   				'onUpdate' => self::RESTRICT
   	   		)
   	   );
   }
?>