<?php

	/**
	 * Class permettant l'authentification
	 * @author Valentin
	 *
	 */
	class Core_Auth{
		
		protected $_tableConnexion;
		protected $_rowLogin;
		protected $_rowPassword;
		
		protected $_login;
		protected $_password;
		protected $_storage;
		 
		public function __construct($tableConnexion, $rowLogin, $rowPassword){
			$this->_tableConnexion = $tableConnexion;
			$this->_rowLogin = $rowLogin;
			$this->_rowPassword = $rowPassword;
		}
		
		/**
		 * Enregistre le login entré
		 * @param string $login
		 * @return Core_Auth
		 */
		public function setIdentity($login){
			$this->_login = $login;
			return $this;
		}
		
		/**
		 * Enregistre la mot de passe enregistré
		 * @param string $password
		 * @return Core_Auth
		 */
		public function setCredential($password){
			$this->_password = $password;
			return $this;
		}
		
		/**
		 * Enregistre le login et le mot de passe
		 * @param string $login
		 * @param string $password
		 * @return Core_Auth
		 */
		public function setIdentitys($login, $password){
			$this->_login = $login;
			$this->_password = $password;
			return $this;
		}
		
		/**
		 * Vérifie si les identifiants sont bons
		 */
		public function isValid(){
			
			$model = new Core_DbTable_ORM();
			
			$req = $model->select()
						->from($this->_tableConnexion)
						->where($this->_rowLogin.' = :login', $this->_login, 'str');
			
			$result = $req->fetch(null, PDO::FETCH_OBJ);
			
			if($result !== false){
				$pass = $this->_rowPassword;
				$passHash = $result->$pass;
				
				if (crypt($this->_password, '$2x$15$tutrouveraspaslepasszwebftp$') == $passHash){
					
					$storage = new Core_Identity($result);
					Core_Sessions::set('identity', $storage, 'AUTH');
					
					return true;
				}else{
					return _e('AUTH_IDENTITY');
				}
			}else{
				return _e('AUTH_IDENTITY');
			}
		}
	}