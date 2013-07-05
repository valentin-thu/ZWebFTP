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
			//$this->getResource();
		}
		
		/**
		 * Récupère les messages de l'application selon la langue choisie
		 */
		public function getResource(){
			$this->_resource = require_once('../Resources/Languages/'.$this->_language.'/Translate.php');
			return $this;
		}
		
		/**
		 * Retourne un message d'erreur particulier
		 * @param String $key
		 */
		public function getError($key, $var = null){
			
			$error = $this->_resource[$key];
			return ($var != null) ? str_replace('%var%', $var, $error) : $error;
		}
		
	}