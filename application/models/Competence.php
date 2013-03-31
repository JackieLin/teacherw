<?php 
   class Competence extends Zend_Db_Table_Abstract{
   	   /**
   	    * @var string tableName
   	    */
   	   protected $_name = 'competence';
   	   protected $_dependentTables = array('CompetenceRole', 'Teach_type', 'Teach_content', 
   	   		'Teach_subcontent', 'Educate_type', 'Teachno_type');
   }
?>