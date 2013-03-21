<?php 
   /**
    * The table teach_subcontent
    * @author lin bin
    */
   class Teach_subcontent extends Zend_Db_Table_Abstract {
   	   
   	   protected $_name = 'teach_subcontent';
       protected $_referenceMap = array(
          'competence' => array(
   	  				'columns' => array('competence_id'),
   	  				'refTableClass' => 'Competence',
   	  				'refColumns' => array('id'),
   	  				'onDelete' => self::CASCADE,
   	  				'onUpdate' => self::RESTRICT
   	  		),
       	   'content' => array(
       	   	        'columns' => array('content_id'),
   	  				'refTableClass' => 'Teach_content',
   	  				'refColumns' => array('id'),
   	  				'onDelete' => self::CASCADE,
   	  				'onUpdate' => self::RESTRICT
       	   	)
       );
   }
?>