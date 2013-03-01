<?php 
   class CompetenceRole extends Zend_Db_Table_Abstract{
   	   protected $_name = "competence_role";
   	   /**
   	    * @var array the reference map that 
   	    */
   	   protected $_referenceMap = array(
   	       'competence' => array(
   	       	   'columns' => array('com_id'),
   	       	   'refTableClass' => 'Competence',
   	       	   'refColumns' => array('id'),
   	       	   'onDelete' => self::CASCADE,
   	       	   'onUpdate' => self::RESTRICT
   	       	),
   	   		'role' => array(
   	   		    'columns' => array('role_id'),
   	   			'refTableClass' => 'Role',
   	   			'refColumns' => array('id'),
   	   			'onDelete' => self::CASCADE,
   	   			'onUpdate' => self::RESTRICT
   	   		)
   	   );
   }
?>