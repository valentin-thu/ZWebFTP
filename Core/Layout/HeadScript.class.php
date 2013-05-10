<?php

	/**
	 * Initialise les fichiers JS de l'application
	 * @author Valentin
	 *
	 */
	class Core_Layout_HeadScript{
		
		protected $_fileJS = array();
		
		/**
		 * Ajoute un fichier JS à l'application
		 * @param string $url
		 * @return Core_Layout_HeadScript
		 */
		public function appendFile($url){
			$objetJS = Core_Registry::get('headScript', 'HEAD');
				
			if(is_object($objetJS)){
				$objetJS->addFile($url);
				Core_Registry::set('headScript', $objetJS, 'HEAD');
			}else{
		
				$objetJS = new Core_Layout_HeadScript();
				$objetJS->addFile($url);
				Core_Registry::set('headScript', $objetJS, 'HEAD');
			}
		
			return $objetJS;
		}
		
		/**
		 * Ajoute un fichier dans le tableau
		 * @param string $url
		 */
		public function addFile($url){
			array_push($this->_fileJS, '<script type="text/javascript" src="'.$url.'"></script>');
		}
		
		/**
		 * Retourne les fichiers JS sous forme de tableau
		 * @return multitype:
		 */
		public function getFiles(){
			return $this->_fileJS;
		}
		
		/**
		 * Modifie le tableau de fichiers
		 * @param array $newArrayCSS
		 */
		public function setFiles($newArrayJS){
			$this->_fileJS = $newArrayJS;
		}
		
		/**
		 * Affiche les fichiers JS à l'appel en écriture de l'objet
		 * @return string
		 */
		public function __toString(){
			$html = '';
			foreach($this->_fileJS as $script){
				$html .= $script;
			}
			
			return $html;
		}
		
	}