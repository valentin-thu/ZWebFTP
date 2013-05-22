<?php 

	class Applications_Front_Bootstrap extends Core_Bootstrap{
		
		public function _initPlop(){
			echo 'plop Bootstrap<br />';
			$this->headLink()->appendFile('css/plopBootstrap.css');
			$this->headScript()->appendFile('js/plopBootstrap.js');
			$this->headMeta()->setCharset('UTF-8');
			$this->headDoctype()->setDoctype('HTML5');
			$this->headTitle()->setTitle('Bootstrap');
		}
		
	}