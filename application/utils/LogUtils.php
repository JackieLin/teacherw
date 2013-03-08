<?php
 
   class LogUtils{
   	   var $_fileName = null;
   	   
   	   /**
   	    * @param string $fileName  eg: windows  D:/LAMP/apache/logs/output.log
   	    *                              linux    /home/linbin/Zend/output.log
   	    */
   	   public function __construct($fileName="/home/linbin/Zend/output.log"){
   	      $this->_fileName = $fileName;	   
   	   }
   	   
   	   /**
   	    * @return string return the log file content
   	    */
   	   public function getLogContent(){
   	   	   return file_get_contents($this->_fileName);
   	   }
   	   
   	   /**
   	    * @param string $contents   writeLog To file
   	    */
   	   public function writeLog($content){
   	   	   $date = new DateTime();
   	   	   $contents = "\n".$date->format('Y-m-d H:i:s').'   '.__METHOD__.'     '.$content;
   	   	   //echo 'contents'.$contents;
   	   	   file_put_contents($this->_fileName, $contents,FILE_APPEND) or die('LogUtils::writeLog write file is error!!');
   	   }
   	   
   	   /**
   	    * print object or array's attributes
   	    * @param object|array $obj
   	    */
   	   public function printObject($obj){
   	   	   if(!isset($obj)){
   	   	   	   die("LogUtils::printObject  The object or array is not exsist!!");
   	   	   }
   	   	   foreach ($obj as $key => $val){
   	   	   	   $this->writeLog("$key======$val");
   	   	   }
   	   }
   	   
   	   //    linux: $log = new LogUtils();
   	   //    windows: $log = new LogUtils('D:/LAMP/apache/logs/output.log');
   	   //    for($i = 0;$i < count($newpage);$i++){
   	   //     	   $temp = $newpage[$i];
   	   //      	   $log->printObject($temp);
   	   //    }
   }
?>