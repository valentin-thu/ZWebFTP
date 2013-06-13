<?php
	
	/**
	 * Retourne un message d'erreur selon $key
	 * @param string $key
	 */
	function _e($key){
		$resources = Core_Registry::get('Translate', 'RESOURCES');
		return $resources->getError($key);
	}