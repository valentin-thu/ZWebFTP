<?php 
	
	/**
	 * Validator entier
	 * @author Valentin
	 *
	 */
	class Core_Form_Validator_Integer extends Core_Form_Validator{
		
		protected $_value;
		
		public function __construct($elts){
			$this->_value = $elts->getValue();
		}
		
		/**
		 * Vérifie si la valeur de l'élément est une adresse mail
		 * @return boolean or string
		 */
		public function isValid(){
			if(preg_match('#^[0-9]*$#', $this->_value)){
				return true;
			}	else{
				return _e('VALIDATOR_INTEGER');
			}
		}
		
	}