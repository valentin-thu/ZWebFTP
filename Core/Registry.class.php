<?php 
	
	/**
	 * Sauvegarde des variables
	 * @author Valentin
	 *
	 */
	class Core_Registry{
		
		private static $_registry = array();
		
		/**
		 * Retourne une variable stockée
		 * @param string $key
		 * @param string $nameSpace
		 * @return string or NULL
		 */
		public static function get($key, $nameSpace = null){

			if($nameSpace == null){
				if(isset(self::$_registry[$key])){
					return self::$_registry[$key];
				}
			}else{
				if(isset(self::$_registry[$nameSpace][$key])){
					return self::$_registry[$nameSpace][$key];
				}
			}

			return null;
		}
		
		/**
		 * Modifie une variable stockée
		 * @param string $key
		 * @param string $value
		 * @param string $nameSpace
		 */
		public static function set($key, $value, $nameSpace = null){
			
			if($nameSpace == null){
				self::$_registry[$key] = $value;
			}else{
				self::$_registry[$nameSpace][$key] = $value;
			}
		}
		
	}