<?php 
   class Role extends Zend_Db_Table_Abstract{
   	   /**
   	    * @var string table name
   	    */
   	   protected $_name = 'role';
   	   protected $_dependentTables = array('Competence_role','Role_user');
   }
?>