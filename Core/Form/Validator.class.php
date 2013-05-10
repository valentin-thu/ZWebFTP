<?php
	
	/**
	 * Méthode nécessaire pour les validator
	 * @author Valentin
	 *
	 */
	class Core_Form_Validator{
		
		/**
		 * Retourne un message d'erreur particulier
		 * @param String $key
		 */
		public function _e($key){
			$resources = Core_Registry::get('Translate', 'RESOURCES');
			return $resources->getError($key);
		}
		
		
	}