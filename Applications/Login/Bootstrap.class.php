<?php 

	class Applications_Login_Bootstrap extends Core_Bootstrap{
		
		public function _initTest(){
			Core_Registry::set('bootstrap', 'registryBootstrap');
		}
		
	}