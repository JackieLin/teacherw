<?php 
   /**
    * The table teach_content
    * @author lin bin
    */
   class Teach_content extends Zend_Db_Table_Abstract{
   	  
   	  protected $_name = 'teach_content';
   	  protected $_dependentTables = array('Teach_subcontent');
   	  
   	  protected $_referenceMap = array(
   	  		'competence' => array(
   	  				'columns' => array('competence_id'),
   	  				'refTableClass' => 'Competence',
   	  				'refColumns' => array('id'),
   	  				'onDelete' => self::CASCADE,
   	  				'onUpdate' => self::RESTRICT
   	  		),
   	  		
   	  		'type' => array(
   	  		       'columns' => array('type_id'),
   	  			   'refTableClass' => 'Teach_type',
   	  		       'refColumns' => array('id'),
   	  			   'onDelete' => self::CASCADE,
   	  			   'onUpdate' => self::RESTRICT
   	  		)
   	  );
   }
?>