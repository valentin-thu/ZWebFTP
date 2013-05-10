<?php
	
	/**
	 * Initialise des objets utilisables dans le Bootstrap, Controller et Layout
	 * @author Valentin
	 *
	 */
	class Core_Init{
		
		protected $_headLink;
		protected $_headScript;
		protected $_headTitle;
		protected $_headMeta;
		protected $_headDoctype;
		
		/**
		 * Initialise les objets constituants le header
		 */
		public function __construct(){
			$CSS = Core_Registry::get('headLink', 'HEAD');
			$JS = Core_Registry::get('headScript', 'HEAD');
			$Title = Core_Registry::get('headTitle', 'HEAD');
			$Meta = Core_Registry::get('headMeta', 'HEAD');
			$Doctype = Core_Registry::get('headDoctype', 'HEAD');
			
			$this->_headLink = ($CSS != NULL) ? $CSS : new Core_Layout_HeadLink();
			$this->_headScript = ($JS != NULL) ? $JS : new Core_Layout_HeadScript();
			$this->_headTitle = ($Title != NULL) ? $Title : new Core_Layout_HeadTitle();
			$this->_headMeta = ($Meta != NULL) ? $Meta : new Core_Layout_HeadMeta();
			$this->_headDoctype = ($Doctype != NULL) ? $Doctype : new Core_Layout_HeadDoctype();
		}
		
		/**
		 * Retourne l'objet CSS
		 * @return Core_Layout_HeadLink
		 */
		public function headLink(){
			return $this->_headLink;
		}
		
		/**
		 * Retourne l'objet JS
		 * @return Core_Layout_HeadScript
		 */
		public function headScript(){
			return $this->_headScript;
		}
		
		/**
		 * Retourne l'objet Title
		 * @return Core_Layout_HeadTitle
		 */
		public function headTitle(){
			return $this->_headTitle;
		}
		
		/**
		 * Retourne l'objet Meta
		 * @return Core_Layout_HeadMeta
		 */
		public function headMeta(){
			return $this->_headMeta;
		}
		
		/**
		 * Retourne l'objet Doctype
		 * @return Core_Layout_HeadDoctype
		 */
		public function headDoctype(){
			return $this->_headDoctype;
		}
		
	}