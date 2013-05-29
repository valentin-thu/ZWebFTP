<?php

	/**
	 * Initialise les fichiers CSS de l'application
	 * @author Valentin
	 *
	 */
	class Core_Layout_HeadLink{
		
		protected $_fileCSS = array();
		
		/**
		 * Ajoute un fichier CSS à l'application
		 * @param string $url
		 * @param string $media
		 * @return Core_Layout_HeadLink
		 */
		public function appendFile($url, $media = 'screen'){
			$objetCSS = Core_Registry::get('headLink', 'HEAD');
			
			if(is_object($objetCSS)){
				$objetCSS->addFile($url, $media);
				Core_Registry::set('headLink', $objetCSS, 'HEAD');
			}else{
				
				$objetCSS = new Core_Layout_HeadLink();
				$objetCSS->addFile($url, $media);
				Core_Registry::set('headLink', $objetCSS, 'HEAD');
			}

			return $objetCSS;
		}
		
		/**
		 * Ajoute un fichier dans le tableau
		 * @param string $url
		 * @param string $media
		 */
		private function addFile($url, $media = 'screen'){
			array_push($this->_fileCSS, '<link rel="stylesheet" type="text/css" media="'.$media.'" href="'.$url.'" />');
		}
		
		/**
		 * Ajoute un favicon à l'application
		 * @param string $favicon
		 * @param string $type
		 * @return Core_Layout_HeadLink
		 */
		public function addFavicon($favicon, $type = 'png'){
			$objetCSS = Core_Registry::get('headLink', 'HEAD');
			
			if(is_object($objetCSS)){
				$objetCSS->_addFavicon($favicon, $type);
				Core_Registry::set('headLink', $objetCSS, 'HEAD');
			}else{
				$objetCSS = new Core_Layout_HeadLink();
				$objetCSS->_addFavicon($favicon, $type);
				Core_Registry::set('headLink', $objetCSS, 'HEAD');
			}
			
			return $objetCSS;
		}
		
		/**
		 * Ajoute un favicon au tableau de Link
		 * @param unknown $favicon
		 * @param string $type
		 */
		private function _addFavicon($favicon, $type = 'png'){
			switch($type){
				case 'png': $typeImage = 'image/png';break;
				default : $typeImage = 'image/png';
			}
			
			array_push($this->_fileCSS, '<link rel="icon" type="'.$typeImage.'" href="'.$favicon.'" />');
		}
		
		/**
		 * Retourne les fichiers CSS sous forme de tableau
		 * @return multitype:
		 */
		public function getFiles(){
			return $this->_fileCSS;
		}
		
		/**
		 * Modifie le tableau de fichiers
		 * @param array $newArrayCSS
		 */
		public function setFiles($newArrayCSS){
			$this->_fileCSS = $newArrayCSS;
		}
		
		/**
		 * Affiche les fichiers CSS à l'appel en écriture de l'objet
		 * @return string
		 */
		public function __toString(){
			$html = '';
			$objetCSS = Core_Registry::get('headLink', 'HEAD');

			foreach($objetCSS->getFiles() as $link){
				$html .= $link;
			}
			
			return $html;
		}
		
	}