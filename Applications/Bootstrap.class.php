<?php 

	class Applications_Bootstrap extends Core_Bootstrap{
		
		public function _initIni(){
			$ini = new Core_Ini(APPLICATIONS_PATH.'Confs/applications.ini');
			Core_Debug::print_r($ini);
		}
		
	}