<?php 
   class LogUtils{
   	   var $_fileName = null;
   	   
   	   public function __construct($fileName){
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
   	   	   $contents = $this->getLogContent();
   	   	   $date = new DateTime();
   	   	   $contents .= "\n".$date->format('Y-m-d H:i:s').'   '.__METHOD__.'     '.$content;
   	   	   echo 'contents'.$contents;
   	   	   file_put_contents($this->_fileName, $contents) or die('LogUtils::writeLog write file is error!!');
   	   }
   }
?>