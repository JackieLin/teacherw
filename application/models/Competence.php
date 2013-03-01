<?php 
   class Competence extends Zend_Db_Table_Abstract{
   	   /**
   	    * @var string tableName
   	    */
   	   protected $_name = 'competence';
   	   protected $_dependentTables = array('Competence_role');
   }
?>