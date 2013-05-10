<?php 
	
	/**
	 * Validator e-mail
	 * @author Valentin
	 *
	 */
	class Core_Form_Validator_Email extends Core_Form_Validator{
		
		protected $_value;
		
		public function __construct($elts){
			$this->_value = $elts->getValue();
		}
		
		/**
		 * Vérifie si la valeur de l'élément est une adresse mail
		 * @return boolean or string
		 */
		public function isValid(){
			if (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $this->_value)){
				return true;
			}else{
				return $this->_e('VALIDATOR_EMAIL');
			}
		}
		
	}