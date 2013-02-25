<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
   function __construct($application){
   	  error_reporting(E_ALL | E_STRICT);
   	  ini_set('display_errors', 'on');
   	  parent::__construct($application);
   }
}

