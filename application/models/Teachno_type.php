<?php
   /**
    * The table teachno_type
    * @author linbin
    */ 
   class Teachno_type extends Zend_Db_Table_Abstract {
   	   
   	  protected $_name = 'teachno_type';
   	  
   	  protected $_referenceMap = array(
   	  		'competence' => array(
   	  				'columns' => array('competence_id'),
   	  				'refTableClass' => 'Competence',
   	  				'refColumns' => array('id'),
   	  				'onDelete' => self::CASCADE,
   	  				'onUpdate' => self::RESTRICT
   	  		)
   	  );
   }
?>