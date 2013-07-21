<?php 

	class Applications_Front_Bootstrap extends Core_Bootstrap{
		
		public function _initHeader(){
			$this->headLink()->appendFile('Css/Bootstrap.css');
			$this->headLink()->appendFile('Css/Front.css');
			$this->headLink()->addFavicon('Images/Login/favicon.png');			
			$this->headScript()->appendFile('Js/Bootstrap.js');
			$this->headScript()->appendFile('Js/Front.js');
		}
		
	}