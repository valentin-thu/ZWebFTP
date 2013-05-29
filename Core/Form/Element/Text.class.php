<?php 

	/**
	 * Crée un élément input de type TEXT
	 * @author Valentin
	 *
	 */
	class Core_Form_Element_Text extends Core_Form_Element{
		
		protected $_type;
		
		public function __construct($name){
			$this->_name = $name;
			$this->_type = 'text';
		}
		
		/**
		 * Retourne le type de l'élément
		 * @return string
		 */
		public function getType(){
			return $this->_type;
		}
		
		/**
		 * Ecris l'élément input
		 * @return string
		 */
		public function renderElement(){

			if($this->hasValue()){
				if(!$this->hasError()){
					$value = 'value="'.$this->getValue().'"';
				}else{
					$value = '';
				}
			}else{
				if($this->_value != ''){
					$value = 'value="'.$this->_value.'"';
				}else{
					$value = '';
				}
			}
			
			$attribs = '';
			if(count($this->_attribs) != 0){
				foreach($this->_attribs as $attrib => $valueAttrib){
					$attribs .= $attrib.'="'.$valueAttrib.'" ';
				}
			}
			
			return '<input type="'.$this->_type.'" name="'.$this->_name.'" '.$value.' '.$attribs.'/>';
		}
		
		public function __toString(){
			return $this->renderElement();
		}
	}

?>