<?php 

	/**
	 * Charge les différentes class à leur appel
	 * @author Valentin
	 *
	 */
	class Autoloader{
		private static $_intance;
		
		private function __construct(){
			spl_autoload_register(array(__CLASS__, 'autoload'));
		}
		
		/**
		 * Charge le fichier contenant la $class 
		 * @param string $class
		 * @throws Exception
		 */
		private static function autoload($class){
			$file = '../'.str_replace('_', DIRECTORY_SEPARATOR, $class) . '.class.php';
			if(!file_exists($file)){
				throw new Exception('Le fichier: <strong>'.$file.'</strong> n\'existe pas.');
			}
			
			require_once $file;
		}
		
		/**
		 * Charge l'autoload
		 */
		public static function getInstance(){
			if(is_null(self::$_intance)){
				self::$_intance = new self;
			}
			
			return self::$_intance;
		}
	}