<?php 

	/**
	 * Gére les sessions
	 * @author Valentin
	 *
	 */
	class Core_Sessions{
		
		/**
		 * Retourne une variable session
		 * @param string $key
		 * @param string $nameSpace
		 * @return string or NULL
		*/
		public static function get($key, $nameSpace = null){
		
			if($nameSpace == null){
				if(isset($_SESSION[$key])){
					return unserialize($_SESSION[$key]);
				}
			}else{
				if(isset($_SESSION[$nameSpace][$key])){
					return unserialize($_SESSION[$nameSpace][$key]);
				}
			}
			
			return null;
		}
		
		/**
		 * Modifie une variable session
		 * @param string $key
		 * @param string $value
		 * @param string $nameSpace
		 */
		public static function set($key, $value, $nameSpace = null){
				
			if($nameSpace == null){
				$_SESSION[$key] = serialize($value);
			}else{
				$_SESSION[$nameSpace][$key] = serialize($value);
			}
		}
		
	}