<?php 
	
	/**
	 * Crée un élement Checkbox
	 * @author Valentin
	 *
	 */
	class Core_Form_Element_Checkbox extends Core_Form_Element{
		
		protected $_type;
		
		public function __construct($name){
			$this->_name = $name;
			$this->_type = 'checkbox';
		}
		
		/**
		 * Retourne le type de l'élément
		 */
		public function getType(){
			return $this->_type;
		}
		
		/**
		 * Ecris l'élément checkbox
		 * @return string
		 */
		public function renderElement(){
			
			$theCheckboxs = '';
			
			foreach($this->_multioption as $theCheckbox){
				$value = 'value="'.$theCheckbox->getVarValue().'"';
					
				$attribs = '';
				if(count($theCheckbox->getAttribs()) != 0){
					foreach($theCheckbox->getAttribs() as $attrib => $valueAttrib){
						$attribs .= $attrib.'="'.$valueAttrib.'" ';
					}
				}
		
				$theCheckboxs .= '<input type="'.$this->_type.'" name="'.$this->_name.'" '.$value.' '.$attribs.'/>'.$theCheckbox->getLabel()->renderElement();
				
			}

			return $theCheckboxs;
		}
		
		public function __toString(){
			return $this->renderElement();
		}
	}

?>