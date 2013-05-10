<?php 
	
	/**
	 * Connexion à un SQBG MySQL 
	 * @author Valentin
	 *
	 */
	class Core_MySQL implements Core_ISQL{
		private $_bdd;
		private static $instance = null;
		
		public function __construct(){
			$this->_bdd = new PDO('mysql:host=localhost;dbname=appli', 'root', '');
		}
		
		/**
		 * Retourne l'objet
		 * @return Core_MySQL
		 */
	 	public static function getInstance(){  
		    if(is_null(self::$instance)){
		      self::$instance = new self;
		    }
		    return self::$instance;
		}
		
		/**
		 * Retourne la connexion à la base de données
		 * @see Core_ISQL::connect()
		 */
		public function connect(){
			return $this->_bdd;
		}
	
	}