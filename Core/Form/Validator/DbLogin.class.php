<?php 
	
	/**
	 * Validator not null
	 * @author Valentin
	 *
	 */
	class Core_Form_Validator_DbLogin extends Core_Form_Validator{
		
		protected $_value;
		protected $_value2;
		
		public function __construct($elts, $log){
			$this->_value = $elts->getValue();
			$this->_value2 = $log->getValue();	
		}
		
		/**
		 * Vérifie si la valeur de l'élément est une adresse mail
		 * @return boolean or string
		 */
		public function isValid(){
			
			$models = new Models_Users();
			$user = $models->getPasswordByLogin($this->_value2);
			
			if($user !== false){
				$passHash = $user->password_users;
				
				if (crypt($this->_value, '$2x$15$tutrouveraspaslepasszwebftp$') == $passHash){
					return true;
				}else{
					return $this->_e('VALIDATOR_DBLOGIN');
				}
			}else{
				return $this->_e('VALIDATOR_DBLOGIN');
			}
		}
		
	}