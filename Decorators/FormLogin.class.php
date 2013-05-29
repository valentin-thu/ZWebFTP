<?php 

	class Decorators_FormLogin{
		
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
			$tabElement = (object)$this->_form->getElements();
			$attribs = $this->_form->renderAttribs();
				
			$html = '<form style="position:relative;top:-10px;" method="'.$this->_form->getMethod().'" action="'.$this->_form->getAction().'" '.$attribs.'>';
			$html .= '<table>';
			
			$html .= '<tr><td>'.$tabElement->login.'</tr></td>';
			$html .= '<tr><td>'.$tabElement->password.'</tr></td>';
			$html .= '<tr><td style="padding-left:10px;padding-top:20px;">'.$tabElement->souvenir.'</tr></td>';
			$html .= '<tr><td style="text-align:center;padding-top:65px;">'.$tabElement->connexion.'</tr></td>';
			
			$html .= '</table>';
			$html .= '</form>';
				
			return $html;
		}
		
	}