<?php 
  /**
   * The education type
   * @author linbin
   */
   class Educate_type extends Zend_Db_Table_Abstract{
   	  protected $_name = 'educate_type';
   	  
   	  protected $_dependentTables = array('Educate_content');
   	  
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