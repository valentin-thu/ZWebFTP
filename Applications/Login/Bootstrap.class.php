<?php 

	class Applications_Login_Bootstrap extends Core_Bootstrap{
		
		public function _initHeader(){
			$this->headLink()->appendFile('Css/Login.css');
			$this->headLink()->appendFile('http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic');
			$this->headLink()->addFavicon('Images/Login/favicon.png');
		}
		
	}