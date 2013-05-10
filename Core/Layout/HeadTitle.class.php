<?php
	
	/**
	 * Modifie le title de l'application
	 * @author Valentin
	 *
	 */
	class Core_Layout_HeadTitle{
		
		protected $_headTitle = '';
		
		/**
		 * Retourne le title
		 */
		public function getTitle(){
			return '<title>'.$this->_headTitle.'</title>';
		}
		
		/**
		 * Modifie le title passé en paramètre
		 * @param string $newTitle
		 * @return Core_Layout_HeadTitle
		 */
		public function setTitle($newTitle){
			$objetTitle = Core_Registry::get('headTitle', 'HEAD');
				
			if(is_object($objetTitle)){
				$objetTitle->setVarTitle($newTitle);
				Core_Registry::set('headTitle', $objetTitle, 'HEAD');
			}else{
		
				$objetTitle = new Core_Layout_HeadTitle();
				$objetTitle->setVarTitle($newTitle);
				Core_Registry::set('headTitle', $objetTitle, 'HEAD');
			}
		
			return $objetTitle;
		}
		
		/**
		 * Modifie la variable title de l'objet
		 * @param string $newTitle
		 */
		public function setVarTitle($newTitle){
			$this->_headTitle = $newTitle;
		}
		
		/**
		 * Vérifie si un title est présent
		 * @return boolean
		 */
		public function hasTitle(){
			return ($this->_headTitle != '') ? true : false;
		}
		
		/**
		 * Affiche le title de l'application lors de l'appel en écriture de l'objet
		 * @return string
		 */
		public function __toString(){
			return $this->getTitle();
		}
		
	}