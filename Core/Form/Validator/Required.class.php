<?php 
	
	/**
	 * Validator not null
	 * @author Valentin
	 *
	 */
	class Core_Form_Validator_Required extends Core_Form_Validator{
		
		protected $_value;
		
		public function __construct($elts){
			$this->_value = $elts->getValue();		
		}
		
		/**
		 * Vérifie si la valeur de l'élément est une adresse mail
		 * @return boolean or string
		 */
		public function isValid(){			
			if ($this->_value != ''){
				return true;
			}else{
				return _e('VALIDATOR_REQUIRED');
			}
		}
		
	}