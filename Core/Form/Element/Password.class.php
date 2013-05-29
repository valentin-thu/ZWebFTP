<?php 

	/**
	 * Crée un input de type PASSWORD
	 * @author Valentin
	 *
	 */
	class Core_Form_Element_Password extends Core_Form_Element{
		
		protected $_type;
		
		public function __construct($name){
			$this->_name = $name;
			$this->_type = 'password';
		}
		
		/**
		 * Retourne le type de l'élément
		 * @return string
		 */
		public function getType(){
			return $this->_type;
		}
		
		/**
		 * Ecris l'élément
		 * @return string
		 */
		public function renderElement(){
			$value = ($this->_value != '') ? 'value="'.$this->_value.'"' : '';
			
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