<?php
   /**
    * The utils that deal with picture
    * @author lin bin
    */
   class ImageDataUtils{
   	   private $_imagesrc;
   	   
   	   /**
   	    * @param string $imagesrc The image path
   	    */
   	   public function __construct($imagesrc){
   	   	   if(!isset($imagesrc)){
   	   	   	   die("ImageDataUtils::__construct  The image path should be exsist!!");
   	   	   }
   	   	   $this->_imagesrc = $imagesrc;
   	   }
   	   
   	   /**
   	    * get the image data
   	    * @return string      The image data stream
   	    */
   	   public function getImageData(){
   	   	   return fread(fopen($this->_imagesrc, 'rb'), filesize($this->_imagesrc));
   	   }
   	   
   	   /**
   	    * 
   	    * @return Ambigous <>  The image mime
   	    */
   	   public function getImageMime(){
   	   	   $info = getimagesize($this->_imagesrc);
   	   	   return $info['mime'];
   	   }
   }
?>