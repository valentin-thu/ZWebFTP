<?php
	
	/**
	 * Class permettant de débuggué
	 * @author Valentin
	 *
	 */
	class Core_Debug{
		
		/**
		 * Retourne un var_dump()
		 * @param unknown $var
		 */
		static public function dump($var){
			return var_dump($var);
		}
		
		/**
		 * Retourne un print_r()
		 * @param unknown $var
		 */
		static public function print_r($var){
			echo '<pre>';
			echo print_r($var);
			echo '</pre>';
		}
		
	}