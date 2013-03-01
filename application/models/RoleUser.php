<?php
  require_once 'User.php';
  require_once 'Role.php';
  class RoleUser extends Zend_Db_Table_Abstract{
  	   protected $_name = "role_user";
  	   
  	   protected $_referenceMap = array(
  	        'Role' => array(
  	            'columns' => array('role_id'),
  	        	'refTableClass' => 'Role',
  	        	'refColumns' => array('id'),
  	            'onDelete' => self::CASCADE,
  	        	'onUpdate' => self::RESTRICT
  	        ),
  	   		'User' => array(
  	   		    'columns' => 'user_id',
  	   			'refTableClass' => 'User',
  	   			'refColumns' => 'id',
  	   			'onDelete' => self::CASCADE,
  	   			'onUpdate' => self::RESTRICT
  	   		)   
  	   );
  }
?>