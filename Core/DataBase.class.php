<?php
	
	/**
	 * Class de connexion à un SGBD
	 * @author Valentin
	 *
	 */
	class Core_DataBase{	
		private $_bdd;
		private $_action;
		
		private $_arrayProp = array('_bdd', '_action', '_arrayProp');
		
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
		
		/**
		 * Modifie l'action des requêtes (insert ou update)
		 * @param string $action
		 */
		private function setAction($action){
			$this->_action = $action;
		}
		
		/**
		 * Crée un objet pour l'insertion
		 * @return Models_Test
		 */
		public function create(){
			$newModel = new Models_Test();
			$newModel->setAction('insert');
			return $newModel;
		}
		
		/**
		 * Enregistre les données dans la base de données
		 */
		public function save(){
			$props = get_object_vars($this);
				
			$query = '';
			$i=0;
				
			$id = '';
			
			$rows = '';
			$insertValue = '';
			foreach($props as $key=>$value){
				
				if(!in_array($key, $this->_arrayProp)){
				
					$i++;
					if($this->_action == 'insert'){
						$rows .= $key;
						$insertValue .= '\''.$value.'\'';
						
						if((count($props) - count($this->_arrayProp)) > $i){
							$rows .= ', ';
							$insertValue .= ', ';
						}
					}else{
						if($key == 'id'){
							$id = 'id = \''.$value.'\'';
						}

						$query .= $key.' = \''.$value.'\'';
						if((count($props) - count($this->_arrayProp)) > $i){
							$query .= ', ';
						}
					}
				}
			}
			if($this->_action == 'insert'){
				$sql = $this->_bdd->prepare('INSERT INTO test ('.$rows.') VALUES ('.$insertValue.')');
			}else{
				$sql = $this->_bdd->prepare('UPDATE test SET '.$query.' WHERE '.$id);
			}
			
			$sql->execute();
		}
		
		public function fetch($query){
			//$query = 'SELECT * FROM test WHERE id = 1';
			$sql = $this->_bdd->prepare($query);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Models_Test');
			$sql->execute();
		
		
			return $sql->fetch();
		}
	}