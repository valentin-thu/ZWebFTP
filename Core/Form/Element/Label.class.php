<?php 
	
	/**
	 * Crée un élement label
	 * @author Valentin
	 *
	 */
	class Core_Form_Element_Label extends Core_Form_Element{
		
		protected $_for;
		
		public function __construct($name, $for = null){
			$this->_nameLabel = $name;
			$this->_for = $for;
		}
		
		/**
		 * Ecris le label à l'élément
		 * @return string
		 */
		public function renderElement(){
			
			$for = ($this->_for != '') ? 'for="'.$this->_for.'"' : '';
			
			$attribs = '';
			if(count($this->_attribs) != 0){
				foreach($this->_attribs as $attrib => $valueAttrib){
					$attribs .= $attrib.'="'.$valueAttrib.'" ';
				}
			}
			
			return '<label '.$for.$attribs.'>'.$this->_nameLabel.'</label>';
		}
	}

?>