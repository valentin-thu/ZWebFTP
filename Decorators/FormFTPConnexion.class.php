<?php 

	class Decorators_FormFTPConnexion{
		
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
			
			if($tabElement->hote->hasError() || $tabElement->port->hasError() || $tabElement->login->hasError() || $tabElement->password->hasError()){
				$modal = 'false';
				$reload = 'false';
			}else{
				$modal = 'true';
				$reload = 'true';
			}
				
			$html = '<form method="'.$this->_form->getMethod().'" action="'.$this->_form->getAction().'" '.$attribs.' data-hidden="'.$modal.'" data-reload="'.$reload.'">';
			$eltsHote = '<table style="width:100%;padding:10px;"><tr>';
			
			$eltsError = '';
			$eltsError2 = '';
			
			$eltsHote .= '<td style="width:70%;">';
			if($tabElement->hote->hasError()){
				$eltsHote .= '<div class="control-group error"><div class="controls">';
				$tabElement->hote->setAttrib('id', 'inputError');
				$eltsHote .= $tabElement->hote;
				$eltsHote .= '</div></div>';
			}else{
				$eltsHote .= $tabElement->hote;
			}
			$eltsHote .= '</td>';
			
			$eltsPort = '<td style="width:15%">';
			if($tabElement->port->hasError()){
				$eltsPort .= '<div class="control-group error"><div class="controls">';
				$tabElement->port->setAttrib('id', 'inputError');
				$eltsPort .= $tabElement->hote;
				$eltsPort .= '</div></div>';
			}else{
				$eltsPort .= $tabElement->port;
			}
			$eltsPort .= '</td></tr>';
			
			if($tabElement->hote->hasError() || $tabElement->port->hasError()){
				$eltsError = '<tr><td>';
				if($tabElement->hote->hasError()){
					$eltsError .= '<span class="help-inline error" style="position:relative;top:-5px;">'.$tabElement->hote->getError().'</span>';
				}
				$eltsError .= '</td><td>';
				if($tabElement->port->hasError()){
					$eltsError .= '<span class="help-inline error" style="position:relative;top:-5px;">'.$tabElement->port->getError().'</span>';
				}
				$eltsError .= '</td></tr>';
			}
			
			$eltsError .= '</table>';
			$eltsLogin = '<table style="width:100%"><tr>';
			
			$eltsLogin .= '<td style="width:50%;">';
			if($tabElement->login->hasError()){
				$eltsLogin .= '<div class="control-group error"><div class="controls">';
				$tabElement->login->setAttrib('id', 'inputError');
				$eltsLogin .= $tabElement->login;
				$eltsLogin .= '</div></div>';
			}else{
				$eltsLogin .= $tabElement->login;
			}
			$eltsLogin .= '</td>';
			
			$eltsPassword = '<td style="width:58%;">';
			if($tabElement->password->hasError()){
				$eltsPassword .= '<div class="control-group error"><div class="controls">';
				$tabElement->password->setAttrib('id', 'inputError');
				$eltsPassword .= $tabElement->password;
				$eltsPassword .= '</div></div>';
			}else{
				$eltsPassword .= $tabElement->password;
			}
			$eltsPassword .= '</td></tr>';
			
			if($tabElement->login->hasError() || $tabElement->password->hasError()){
				$eltsError2 = '<tr><td>';
				if($tabElement->login->hasError()){
					$eltsError2 .= '<span class="help-inline error" style="position:relative;top:-5px;">'.$tabElement->login->getError().'</span>';
				}
				$eltsError2 .= '</td><td>';
				if($tabElement->password->hasError()){
					$eltsError2 .= '<span class="help-inline error" style="position:relative;top:-5px;">'.$tabElement->password->getError().'</span>';
				}
				$eltsError2 .= '</td></tr>';
			}
			$eltsError2 .= '</table>';
			
			$html .= $eltsHote.$eltsPort.$eltsError.$eltsLogin.$eltsPassword.$eltsError2;
			
			
			$html .= '</form>';
				
			return $html;
		}
		
	}