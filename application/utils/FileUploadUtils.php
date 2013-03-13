<?php
   /**
    * 处理上传文件
    * @author lin bin
    */
   class FileUploadUtils{
   	   // 提交时的链接名称
   	   private $_uploadname;
   	   // 提交时文件名称
   	   private $_uploadfilename;
   	   // 保存文件路径
   	   private $_path;
   	   // 文件类型
   	   private $_type;
   	   // 存储时最后名称
   	   private $_name;
   	   // 文件大小限制, 默认3m
   	   private $_size;
   	   /**
   	    * 
   	    * @param string $uploadname        上传时识别名称
   	    * @param string $uploadfilename    上传时文件名
   	    * @param string $path              上传时文件路径
   	    * @param string $name              最后保存名称
   	    * @param string $type              文件类型
   	    */
   	   public function __construct($uploadname, $uploadfilename, $path, $name, $type=null, $size = null){
   	   	    if(!isset($uploadname, $uploadfilename, $path, $name)){
   	   	    	die("FileUploadUtils::__construct The uploadname and uploadfilename 
   	   	    			and path and name must be exsist!!");
   	   	    }
   	   	    $this->_size = (isset($size)) ? $size : 1024*1024*3;
   	   	    $this->_type = (isset($type)) ? $type : "image/jpeg";
   	   	    $this->_uploadname = $uploadname;
   	   	    $this->_uploadfilename = $uploadfilename;
   	   	    $this->_path = $path;
   	   	    $this->_name = $name;
   	   }
   	   
   	   /**
   	    * upload file to the path
   	    */
   	   public function upload(){
   	   	   $tmpfile = $_FILES[$this->_uploadname];
   	   	   $file = $tmpfile[$this->_uploadfilename];
   	   	   if(is_uploaded_file($file)){
   	   	   	  $size = $tmpfile['size'];
   	   	   	  $type = $tmpfile['type'];
   	   	   	  if($size > $this->_size){
   	   	   	  	  return "oversize";
   	   	   	  } else{
   	   	   	  	 if($type !== $this->_type){
   	   	   	  	 	return 'typeerror';
   	   	   	  	 }
   	   	   	  	 // 上传
   	   	   	  	 move_uploaded_file($file, $this->_path.$this->_name);
   	   	   	  }
   	   	   	  return 'success';
   	   	   } else{
   	   	   	  return 'error';
   	   	   }
   	   }
   }
?>