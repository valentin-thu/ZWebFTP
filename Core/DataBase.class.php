<?php
	
	/**
	 * Class de connexion à un SGBD
	 * @author Valentin
	 *
	 */
	class Core_DataBase{	
		protected $bdd;
		
		public function __construct(){
			$this->getSGBD();
		}
		
		/**
		 * 
		 * Permet de lancer une connexion sql en fonction du sgbd
		 * @throws exception
		 */
		private function getSGBD(){
			$conf = array(
				'name' => 'mysql'
			);
			
			switch ($conf['name']){
				case 'mysql' :
					$this->bdd = Core_MySQL::getInstance()->connect();
					break;
				default:
					throw new exception(sprintf('Aucun SGBD ne peut être sélectionné'));
					break;
			}
		}
	}