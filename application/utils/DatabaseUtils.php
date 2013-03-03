<?php 
   /**
    * @author linbin
    */
   class DatabaseUtils{
   	   
   	   /**
   	    * The fetch table and return data
   	    * @param  object $table The table object
   	    * @param  resource $db The database link
   	    * @param array $datas {
   	    *     'field' => 'value'
   	    * }
   	    * @param string $flag the value are 'row' or 'all'
   	    * @return object|array $row the result set about the table
   	    */
   	   public function fetchData($table,$db,$datas,$flag='row'){
   	   	   //$type = var_dump($datas); 
   	   	   $length = count($datas);
   	   	   $where = null;
   	   	   $order = null;
   	   	   $count = null;
   	   	   $offset = null;
   	   	   $row = null;
   	   	   if(!isset($table) || !is_array($datas) || !isset($db)){
   	   	   	   die("DatabaseUtils::fetchData The table object is unset or the datas is not an array or the link is null");
   	   	   }
   	   	   
   	   	   foreach ($datas as $key => $val){
   	   	   	   if($key == 'order'){
   	   	   	   	   if(!isset($order)){
   	   	   	   	   	   $order = array();
   	   	   	   	   }
   	   	   	   	   $arr = $val->split(',');
   	   	   	   	   foreach ($arr as $v){
   	   	   	   	   	   $order[] = $v;
   	   	   	   	   }
   	   	   	   } else if($key == 'count'){
   	   	   	   	   $count = intval($val);
   	   	   	   } else if($key == 'offset'){
   	   	   	   	   $offset = intval($val);
   	   	   	   } else{
   	   	   	   	   if(!isset($where)){
   	   	   	   	   	   $where = $db->quoteInto($key.'=?',$val);
   	   	   	   	   }else{
   	   	   	   	   	   $where .= $db->quoteInto(" AND ".$key.'=?',$val);
   	   	   	   	   }
   	   	   	   }
   	   	   }
   	   	   
   	   	   if($flag == 'row'){
   	   	   	   $row = $table->fetchRow($where,$order,$offset);
   	   	   } else if($flag == 'all'){
   	   	   	   $row = $table->fetchAll($where,$order,$count,$offset);
   	   	   }
   	   	   
   	   	   return $row;
   	   }
   	   
   	   
   	   /**
   	    * @param object $rows   The row that would be used
   	    * @param string $class  The class name that would be used
   	    * @param string $role   The role that used
   	    * @param object $select The where condition
   	    */
   	   public function findDependentRow($rows,$class, $role=null, $select=null){
   	   	    if(!isset($class) || !isset($rows)){
   	   	    	die("DatabaseUtils::findDependentRow the class or the rows should not be null");
   	   	    }
   	   	    return $rows->findDependentRowset($class,$role,$select);
   	   }
   	   
   	   /**
   	    * To deal with many to many relationship
   	    * @param object $rows
   	    * @param string $matchTable the rows table
   	    * @param string $intersectionTable
   	    * @param string $callerRefRule The role that interactionTable to origin table
   	    * @param string $matchTable The role that interactionTable to destination table
   	    */
   	   public function findManyToManyRow($rows,$matchTable,$intersectionTable,$callerRefRule=null,$matchRefRule = null){
   	        if(!isset($matchTable) || !isset($intersectionTable)){
   	        	die("DatabaseUtils::findManyToManyRow the matchTable and intersectionTable should not be null!!");
   	        }
   	        return $rows->findManyToManyRowset($matchTable,$intersectionTable,$callerRefRule,$matchRefRule);
   	   }
   }
?>