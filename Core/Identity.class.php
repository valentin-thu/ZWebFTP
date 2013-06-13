<?php

	class Core_Identity{
		
		protected $_storage;
		
		public function __construct($storage){
			$this->_storage = $storage;
		}
		
		public function getStorage(){
			return $this->_storage;
		}
		
		public function isAuth(){
			return ($this->_storage != '') ? true : false;
		}
	

	}