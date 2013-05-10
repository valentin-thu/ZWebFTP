<?php 

	class Core_Sessions{
		
		public function get($session, $nameSpace = null){
			if($nameSpace == null){
				if(isset($_SESSION[$session])){
					return $_SESSION[$session];
				}
			}else{
				if(isset($_SESSION[$nameSpace][$session])){
					return $_SESSION[$nameSpace][$session];
				}
			}
			
			return null;
		}
		
		public function set($session, $valueSession, $nameSpace = null){
			
			if($nameSpace == null){
				$_SESSION[$session] = $valueSession;
			}else{
				$_SESSION[$nameSpace][$session] = $valueSession;
			}
		
		}
		
		public function issetSessions($session){
			return (isset($session)) ? true : false;
		}
		
	}