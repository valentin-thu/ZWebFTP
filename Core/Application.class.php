<?php 

	/**
	 * Lance l'applicaion
	 * @author Valentin
	 *
	 */
	class Core_Application{
		private $_appli;
	
		public function __construct($appli){
			if(empty($appli)){
				throw new Exception('Veuillez indiquer une application à charger.');
			}
			
			$this->_appli = $appli;
		}
		
		/**
		 * Charge le layout en fonction de l'application
		 */
		public function run(){
			$Layout = new Core_Layout($this->_appli);
			$Layout->create();
		}
	}