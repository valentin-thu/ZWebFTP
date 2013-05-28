<?php
	
	/**
	 * Class de connexion à un SGBD
	 * @author Valentin
	 *
	 */
	class Core_DataBase{	
		protected $_bdd;
		protected $_action;
		
		protected $_arrayProp = array('_bdd', '_action', '_arrayProp',
									'_select', '_from', '_join', '_where',
									'_order', '_limit', '_bindParam', '_error',
									'_name', '_primary', '_bindParamSave'
		);
		
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
					$this->_bdd = Core_MySQL::getInstance()->connect();
					break;
				default:
					throw new exception(sprintf('Aucun SGBD ne peut être sélectionné'));
					break;
			}
		}

	}