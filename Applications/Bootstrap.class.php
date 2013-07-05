<?php 

	class Applications_Bootstrap extends Core_Bootstrap{
		
		public function _initIni(){
			$ini = new Core_Ini(APPLICATIONS_PATH.'Confs/applications.ini', 'development');
			Core_Registry::set('Ini', $ini, 'CONFIGURATION');
			Core_Registry::set('Connexion', $ini->database, 'DATABASE');
		}
		
		public function _initTranslate(){
			$resource = new Core_Translate('fr');
			$translate = $resource->getResource();
			Core_Registry::set('Translate', $translate, 'RESOURCES');
		}
		
		public function _initHeader(){
			$this->headLink()->appendFile('Css/ResetCSS.css');
			$this->headLink()->appendFile('Css/Library.css');
			$this->headLink()->appendFile('Css/jQuery-UI.css');
			$this->headScript()->appendFile('Js/jQuery.js');
			$this->headScript()->appendFile('Js/jQuery-UI.js');
			$this->headScript()->appendFile('Js/jQuery-UI-Fr.js');
			$this->headScript()->appendFile('Js/Library.js');
			$this->headDoctype()->setDoctype('HTML5');
			$this->headMeta()->setCharset('UTF-8');
		}
		
	}