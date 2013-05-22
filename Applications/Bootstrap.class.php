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
		
	}