<?php
/**
    * The cookie utils
    * @author linbin
    */
class CookieUtils {
	private $_name;
	private $_value;
	private $_expire;
	private $_path = '/';
	
	/**
	 * To set cookie with the name
	 * @return bool
	 */
	public function setCookie() {
		if(!isset($this->_name) || !isset($this->_value) || !isset($this->_expire)){
			die("CookieUtils:: setcookie The cookie name and value and expire should be exsist!!");
		}
		return setcookie($this->_name, $this->_value, $this->_expire, $this->_path);
	}
	/**
	 * @return the $_name
	 */
	public function getName() {
		return $this->_name;
	}
	
	/**
	 * @param string $_name        	
	 */
	public function setName($_name) {
		$this->_name = $_name;
	}
	/**
	 * @return the $_value
	 */
	public function getValue() {
		return $this->_value;
	}

	/**
	 * @return the $_expire
	 */
	public function getExpire() {
		return $this->_expire;
	}

	/**
	 * @param string $_value
	 */
	public function setValue($_value) {
		$this->_value = $_value;
	}

	/**
	 * @param int $_expire
	 */
	public function setExpire($_expire) {
		$this->_expire = $_expire;
	}
	/**
	 * @return the $_path
	 */
	public function getPath() {
		return $this->_path;
	}

	/**
	 * @param string $_path
	 */
	public function setPath($_path) {
		$this->_path = $_path;
	}
}
?>