<?php 
	
	/**
	 * Validator caractères maximum
	 * @author Valentin
	 *
	 */
	class Core_Form_Validator_Maxlength extends Core_Form_Validator{
		
		protected $_value;
		protected $_max;
		
		public function __construct($elts, $maxlength){
			$this->_value = $elts->getValue();
			$this->_max = $maxlength;
		}
		
		/**
		 * Vérifie si la valeur de l'élément est une adresse mail
		 * @return boolean or string
		 */
		public function isValid(){
			if(strlen($this->_value) <= $this->_max){
				return true;
			}else{
				return _e('VALIDATOR_MAXLENGTH', $this->_max);
			}
		}
		
	}