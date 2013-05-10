<?php
	
	/**
	 * Initialise les meta TAG de l'application
	 * @author Valentin
	 *
	 */
	class Core_Layout_HeadMeta{
		
		protected $_arrayMeta = array();
		
		/**
		 * Retourne les meta tag sous forme de tableau
		 * @return multitype:
		 */
		public function getMetas(){
			return $this->_arrayMeta;
		}
		
		/**
		 * Modifie le tableau $_arrayMeta par $newArrayMeta
		 * @param array $newArrayMeta
		 */
		public function setMetas($newArrayMeta){
			$this->_arrayMeta = $newArrayMeta;
		}
		
		/**
		 * Modifie le charset de l'application
		 * @param string $charset
		 * @return Core_Layout_HeadMeta
		 */
		public function setCharset($charset){
			$objetMeta = Core_Registry::get('headMeta', 'HEAD');
				
			if(is_object($objetMeta)){
				$objetMeta->addMeta($charset);
				Core_Registry::set('headMeta', $objetMeta, 'HEAD');
			}else{
		
				$objetMeta = new Core_Layout_HeadMeta();
				$objetMeta->addMeta($charset);
				Core_Registry::set('headMeta', $objetMeta, 'HEAD');
			}
		
			return $objetMeta;
		}
		
		/**
		 * Ajoute une balise meta dans $_arrayMeta
		 * @param string $charset
		 */
		public function addMeta($charset){
			array_push($this->_arrayMeta, '<meta charset="'.$charset.'">');
		}
		
		/**
		 * Affiche les balises META du tableau lors de l'appel en écriture
		 * @return string
		 */
		public function __toString(){
			$html = '';
			
			foreach($this->_arrayMeta as $meta){
				$html .= $meta;
			}
			return $html;
		}
		
	}