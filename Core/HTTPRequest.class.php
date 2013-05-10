<?php 
	
	/**
	 * Récupère les paramètres GET et POST sous forme d'objet
	 * @author Valentin
	 *
	 */
	class Core_HTTPRequest{
		
		protected $_post;
		protected $_get;
		protected $_params;
		
		public function __construct(){
			$this->_post = $_POST;
			$this->_get = $_GET;
			$this->_params = array_merge($this->_post, $this->_get);
		}
		
		/**
		 * Retourne tous les paramètres
		 * @return array;
		 */
		public function getParams(){
			return $this->_params;
		}
		
		/**
		 * Retourne un paramètre
		 * @param string $key
		 * @return string or NULL
		 */
		public function getParam($key){
			return ($this->hasParam($key)) ? htmlentities($this->_params[$key], ENT_QUOTES, 'UTF-8') : null;	
		}
		
		/**
		 * Vérifie si un paramètre existe
		 * @param string $key
		 * @return boolean
		 */
		public function hasParam($key){
			return (array_key_exists($key, $this->_params)) ? true : false;
		}
		
		/**
		 * Vérifie si un paramètre POST existe
		 * @param string $key
		 * @return boolean
		 */
		public function hasPost($key){
			return (array_key_exists($key, $this->_post)) ? true : false;
		}
		
		/**
		 * Vérifie si un paramètre GET existe
		 * @param string $key
		 * @return boolean
		 */
		public function hasGet($key){
			return (array_key_exists($key, $this->_get)) ? true : false;
		}
	}
