<?php 
	
	/**
	 * Permet de traduire les messages de l'application
	 * @author Valentin
	 *
	 */
	class Core_Translate{
		
		private $_language;
		private $_resource;
		
		public function __construct($lang){
			$this->_language = $lang;
			$this->getResource();
		}
		
		/**
		 * Récupère les messages de l'application selon la langue choisie
		 */
		private function getResource(){
			$this->_resource = require_once('../Resources/Languages/'.$this->_language.'/translate.php');
			Core_Registry::set('Translate', $this, 'RESOURCES');
		}
		
		/**
		 * Retourne un message d'erreur particulier
		 * @param String $key
		 */
		public function getError($key){
			return $this->_resource[$key];
		}
		
	}