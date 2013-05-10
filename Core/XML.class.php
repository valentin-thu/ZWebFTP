<?php 
	
	/**
	 * Class de chargement de fichier XML
	 * @author Valentin
	 *
	 */
	class Core_XML{
		private $file;
		private $xml;
		
		public function __construct($file){
			$this->file = $file;
			$this->load();		
		}
		
		/**
		 * Charge un fichier XML
		 */
		private function load(){
			$this->xml = simplexml_load_file($this->file);
		}
		
		/**
		 * Retourne le XML traité
		 * @return SimpleXMLElement
		 */
		public function getXml(){
			return $this->xml;
		}
	}