<?php 
	
	/**
	 * Crée un élement au formulaire
	 * @author Valentin
	 *
	 */
	class Core_Form_Element{
		
		protected $_name;
		protected $_label;
		protected $_attribs;
		protected $_value;
		protected $_validators = array();
		protected $_error;
		protected $_multioption = array();
		
		/**
		 * Modifie un attribut
		 * @param string $type
		 * @param string $value
		 */
		public function setAttrib($type, $value){
			$this->_attribs[$type] = $value;
		}
		
		/**
		 * Modifie tous les attributs
		 * @param array $attribs
		 */
		public function setAttribs($attribs){
			$this->_attribs = $attribs;
		}
		
		/**
		 * Retourne un attribut
		 * @param string $type
		 * @return string or NULL
		 */
		public function getAttrib($type){
			return ($this->hasAttrib($type)) ? $this->_attribs[$type] : null;
		}
		
		/**
		 * Retourne tous les attributs
		 * @return array
		 */
		public function getAttribs(){
			return $this->_attribs;
		}
		
		/**
		 * Vérifie si un attribut existe
		 * @param string $attrib
		 * @return boolean
		 */
		public function hasAttrib($attrib){
			return (array_key_exists($attrib, $this->_attribs)) ? true : false;
		}
		
		/**
		 * Retourne la valeur d'un élément
		 * @return string or NULL
		 */
		public function getValue(){
			$httpRequest = new Core_HTTPRequest();
			return ($httpRequest->hasParam($this->_name)) ? $httpRequest->getParam($this->_name) : null; 
		}
		
		/**
		 * Retourne l'attribut VALUE
		 */
		public function getVarValue(){
			return $this->_value;
		}
		
		/**
		 * Modifie l'attribut VALUE
		 * @param string $value
		 */
		public function setValue($value){
			$this->_value = $value;
		}
		
		/**
		 * Retourne l'attribut NAME
		 */
		public function getName(){
			return $this->_name;
		}
		
		/**
		 * Modifie l'attribut NAME
		 * @param string $name
		 */
		public function setName($name){
			$this->_name = $name;
		}
		
		/**
		 * Modifie le label de l'élément
		 * @param Core_Form_Element_Label | string $label
		 */
		public function setLabel($label){
			if(is_object($label)){
				$this->_label = $label;
			}else{
				$this->_label = new Core_Form_Element_Label($label);
			}
		}
		
		/**
		 * Retourne l'objet label de l'élément
		 */
		public function getLabel(){
			return $this->_label;
		}
		
		/**
		 * Ajoute un validator à l'élément
		 * @param string $validator
		 */
		public function addValidator($validator){
			$validatorClass = 'Core_Form_Validator_'.$validator;
			if(class_exists($validatorClass, true)){
				$theValidator = new $validatorClass($this);
				array_push($this->_validators, $theValidator);
			}
		}
		
		/**
		 * Ajoute une checkbox & l'élément
		 * @param string $value
		 * @param string $nameLabel
		 * @return Core_Form_Element_Checkbox
		 */
		public function addMultiOption($value, $nameLabel){
			
			$nbCheckBox = count($this->_multioption) + 1;
			
			$newCheckBox = new Core_Form_Element_Checkbox($this->_name);
			$newLabel = new Core_Form_Element_Label($nameLabel, $this->_name.'-'.$nbCheckBox);
			
			$newCheckBox->setLabel($newLabel);
			$newCheckBox->setValue($value);
			
			$newCheckBox->setAttrib('id', $this->_name.'-'.$nbCheckBox);
			
			array_push($this->_multioption, $newCheckBox);
			
			return $newCheckBox;
		}
		
		/**
		 * Retourne toutes les checkboxs
		 */
		public function getMultiOptions(){
			return $this->_multioption;
		}
		
		/**
		 * Vérifie si l'élément est valide
		 * @return boolean
		 */
		public function isValid(){
			$bool = true;
			foreach($this->_validators as $validator){
				if($validator->isValid() !== true){
					$bool = false;
					$this->_error = $validator->isValid();
				}
			}
			
			return $bool;
		}
		
		/**
		 * Vérifie si l'élément posséde une erreur
		 * @return boolean
		 */
		public function hasError(){
			return ($this->_error != '') ? true : false;
		}
		
		/**
		 * Retourne l'erreur de l'élément
		 */
		public function getError(){
			return $this->_error;
		}
		
		/**
		 * Ecris les différents attributs
		 * @return string
		 */
		public function renderAttribs(){
			if(count($this->_tabAttribs) != 0){
				$attribs = '';
				foreach($this->_tabAttribs as $attribb){
					foreach($attribb as $attrib => $valueAttrib){
						$attribs .= $attrib.'="'.$valueAttrib.'"';
					}
				}
			}else{
				$attribs = '';
			}
		
			return $attribs;
		}
	}