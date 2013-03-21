<?php 
   /**
    * The table teach_type
    * @author lin bin
    */
   class Teach_type extends Zend_Db_Table_Abstract{
   	   
   	  protected $_name = 'teach_type';
   	  protected $_dependentTables = array('Teach_content');
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