<?php

	/**
	 * Class de création de formulaire
	 * @author Valentin
	 *
	 */
	class Core_Form{
		
		private $_tabElement = array();
		private $_method;
		private $_action;
		private $_tabAttribs = array();
		private $_decorator;
		
		/**
		 * Ajoute un élément au formulaire
		 * @param Core_Form_Element $element
		 */
		public function addElement($element){
			$this->_tabElement[$element->getName()] = $element;
		}
		
		/**
		 * Modifie l'attribut method du formulaire
		 * @param string $method
		 */
		public function setMethod($method){
			$this->_method = $method;
		}
		
		/**
		 * Modifie l'attribut action du formulaire
		 * @param string $action
		 */
		public function setAction($action){
			$this->_action = $action;
		}
		
		/**
		 * Retourne l'attribut method du formulaire
		 * @return string
		 */
		public function getMethod(){
			return $this->_method;
		}
		
		/**
		 * Retourne l'attribut action du formulaire
		 * @return string
		 */
		public function getAction(){
			return $this->_action;
		}
		
		/**
		 * Retourne les attributs du formulaire
		 * @return multitype:
		 */
		public function getAttribs(){
			return $this->_tabAttribs;
		}
		
		/**
		 * Ajout d'un attribut au formulaire
		 * @param string $type
		 * @param string $value
		 */
		public function setAttrib($type, $value){
			$attrib[$type] = $value;
			array_push($this->_tabAttribs, $attrib);
		}
		
		/**
		 * Ajout de plusieurs attributs au formulaire
		 * @param array $array
		 */
		public function setAttribs($array){
			array_push($this->_tabAttribs, $array);
		}
		
		/**
		 * Vérifie la validité du formulaire
		 */
		public function isValid(){
			$bool = true;
			foreach($this->_tabElement as $elts){
				if($elts->isValid() === false){
					$bool = false;
				}
			}
			
			return $bool;
		}
		
		/**
		 * Retourne tous les éléments du formulaire
		 * @return array
		 */
		public function getElements(){
			return $this->_tabElement;
		}
		
		/**
		 * Retourne un élément selon son attribut name
		 * @param string $name
		 * @return Core_Form_Element
		 */
		public function getElement($name){
			return $this->_tabElement[$name];
		}
		
		/**
		 * Retourne tous les attributs du formaulire sous forme de chaîne de caractère
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
		
		/**
		 * Affiche les erreurs du formulaire
		 * @return string
		 */
		public function populate(){
			return $this->render(true);
		}
		
		/**
		 * Ajoute un decorator au formulaire
		 * @param string $decorator
		 */
		public function addDecorator($decorator){
			$this->_decorator = $decorator;
		}
		
		/**
		 * Affiche le formulaire avec les decorator choisi et les messages d'erreur
		 * @param bool $populate
		 * @return string
		 */
		public function render($populate = false){
			if($this->_decorator != null){
				$theDecorator = $this->_decorator;
				$decorator = new $theDecorator($this, $populate);
				return $decorator->render();
			}else{
				$decorator = new Core_Form_Decorator_TableWrapper($this, $populate);
				return $decorator->render();
			}
		}
		
		public function __toString(){
			return $this->render();
		}
		
	}