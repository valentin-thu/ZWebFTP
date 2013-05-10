<?php 
	
	/**
	 * Décore le formulaire par un tableau
	 * @author Valentin
	 *
	 */
	class Core_Form_Decorator_TableWrapper{
		
		protected $_form;
		protected $_populate;
		
		public function __construct($form, $populate){
			$this->_form = $form;
			$this->_populate = $populate;
		}
		
		/**
		 * Affiche le formulaire sous forme de tableau
		 * @return string
		 */
		public function render(){
			$tabElement = $this->_form->getElements();
			$attribs = $this->_form->renderAttribs();
			
			$html = '<form method="'.$this->_form->getMethod().'" action="'.$this->_form->getAction().'" '.$attribs.'>';
			$html .= '<table>';
			foreach($tabElement as $element){
				
				$html .= '<tr><td></td><td>'.$element->renderElement();
				
				if($this->_populate == true){
					$html .= ($element->hasError()) ? $element->getError().'</td></tr>' : '</td></tr>';
				}else{
					$html .= '</td></tr>';
				}
			}
			$html .= '</table>';
			$html .= '</form>';
			
			return $html;
		}
		
	}