<?php 
	
	/**
	 * Connexion à un SQBG MySQL 
	 * @author Valentin
	 *
	 */
	class Core_MySQL{
		private $_bdd;
		private static $instance = null;
		
		public function __construct(){
			$db = Core_Registry::get('Connexion', 'DATABASE');
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$this->_bdd = new PDO('mysql:host='.$db->params->host.';dbname='.$db->params->dbname, $db->params->username, $db->params->password, $pdo_options);
				$this->_bdd->exec($db->params->charset);
			}
			catch (Exception $e){
				die('Erreur : ' . $e->getMessage());
			}
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