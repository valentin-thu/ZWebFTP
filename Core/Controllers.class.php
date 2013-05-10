<?php 
	
	/**
	 * Différentes méthodes des controllers
	 * @author Valentin
	 *
	 */
	class Core_Controllers extends Core_Init{
		
		private $_get;
		private $_post;
		private $_layout;
		private $_vars;
		
		public function __construct(){
			$this->_get = $_GET;
			$this->_post = $_POST;
			
			parent::__construct();
		}
		
		/**
		 * Retourne les paramètre GET et POST
		 * @return Core_HTTPRequest
		 */
		public function getRequest(){
			$request = new Core_HTTPRequest();
			return $request;
		}
		
		/**
		 * Modifie le layout de l'application
		 * @param unknown $layout
		 * @throws exception
		 */
		public function setLayout($layout){
			$file = '../Applications/Templates/'.$layout.'.phtml';
	        if(!file_exists($file)){
	        	throw new exception(sprintf('Le fichier template n\'existe pas : %s', $file));
	        }
			$this->_layout = $layout;	
		}
		
		/**
		 * Retoune le layout de l'application
		 * @return unknown
		 */
		public function getLayout(){
			return $this->_layout;
		}
		
		/**
		 * Vérifie si un layout existe
		 * @return boolean
		 */
		public function hasLayout(){
			return (isset($this->_layout)) ? true : false;
		}
		
		/**
		 * Vérifie s'il existe des variables
		 * @return boolean
		 */
		public function hasVars(){
			return (isset($this->_vars) && is_array($this->_vars));
		}
		
		/**
		 * Retourne les variables
		 * @return array
		 */
		public function getVars(){
			return $this->_vars;
		}
		
		/**
		 * Modifie une variable
		 * @param unknown $id
		 * @param unknown $value
		 */
		public function assign($id, $value){
			$this->_vars[$id] = $value;
		}
		
		/**
		 * Vérifie l'utilisateur est authentifié
		 * @return boolean
		 */
		public function isAuth(){
			return (isset($_SESSION['AUTH']) && $_SESSION['AUTH']) ? true : false;
		}
		
		/**
		 * Redirige vers $uri
		 * @param string $uri
		 */
		public function redirect($uri){
			if(!empty($uri)){
				header('Location:'.$uri);
				exit;
			}
		}
		
		/**
		 * Modifie un message d'erreur
		 * @param integer $id
		 * @param string $str
		 */
		public function setError($id, $str){
			if(!isset($_SESSION['ERROR'])){
				$_SESSION['ERROR'] = array();
			}
			
			$_SESSION['ERROR'][$id] = $str;
		}
		
		/**
		 * Retourne un message d'erreur
		 * @param integer $id
		 * @return string
		 */
		public function getError($id){
			if(isset($_SESSION['ERROR'][$id])){
				$error = $_SESSION['ERROR'][$id];
				unset($_SESSION['ERROR'][$id]);
				return $error;
			}
		}
	}