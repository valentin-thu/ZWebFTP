<?php

	/**
	 * Class permettant d'exécuter des requêtes SQL
	 * @author Valentin
	 *
	 */
	class Core_DbTable_ORM extends Core_DataBase{	
		
		protected $_select = '';
		protected $_from = '';
		protected $_join = '';
		protected $_where = '';
		protected $_order = '';
		protected $_limit = '';
		
		protected $_bindParam = array();
		protected $_bindParamSave = array();
		
		protected $_error;
		
		/**
		 * Stocke les clés, valeurs et typage des conditions
		 * @param string $condition
		 * @param array||string $value
		 * @param array||string $typage
		 * @param number $indice
		 */
		private function bindParam($condition, $value, $typage = null, $indice = 0){
			$markKey = ':';
			
			if($this->_where == ''){
				$this->_where = 'WHERE';
			}
			
			if(strpos($condition, $markKey)){
				$debutKey = strpos($condition, $markKey) + strlen($markKey);
				$ssCondition = substr($condition, $debutKey);
				
				if(strpos($ssCondition, ' ')){
					
					$theKey = ':'.str_replace(array('(', ')'), array(''), strstr($ssCondition, ' ', true));
					
					if(is_array($value)){
						if($typage !== null){
							if(is_array($typage)){
								if(array_key_exists($indice, $typage)){
									if(is_object($value[$indice])){
										$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value[$indice]->getBindParam());
										$this->_where = str_replace($theKey, $value[$indice]->toString(), $this->_where);
									}else{
										array_push($this->_bindParam, array($theKey, $value[$indice], $typage[$indice]));
									}
								}else{
									if(is_object($value[$indice])){
										$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value[$indice]->getBindParam());
										$this->_where = str_replace($theKey, $value[$indice]->toString(), $this->_where);
									}else{
										array_push($this->_bindParam, array($theKey, $value[$indice], null));
									}
								}
							}else{
								if(is_object($value[$indice])){
									$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value[$indice]->getBindParam());
									$this->_where = str_replace($theKey, $value[$indice]->toString(), $this->_where);
								}else{
									array_push($this->_bindParam, array($theKey, $value[$indice], $typage));
								}
							}
						}else{
							if(is_object()){
								$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value[$indice]->getBindParam());
								$this->_where = str_replace($theKey, $value[$indice]->toString(), $this->_where);
							}else{
								array_push($this->_bindParam, array($theKey, $value[$indice], null));
							}
						}
					}
					
					$this->bindParam(strstr($ssCondition, ' '), $value, $typage, ++$indice);
					
				}else{
					
					$theKey = ':'.str_replace(array('(', ')'), array(''), $ssCondition);
					
					if(is_array($value)){
						if($typage !== null){
							if(is_array($typage)){
								if(array_key_exists($indice, $typage)){
									if(is_object($value[$indice])){
										$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value[$indice]->getBindParam());
										$this->_where = str_replace($theKey, $value[$indice]->toString(), $this->_where);
									}else{
										array_push($this->_bindParam, array($theKey, $value[$indice], $typage[$indice]));
									}
								}else{
									if(is_object($value[$indice])){
										$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value[$indice]->getBindParam());
										$this->_where = str_replace($theKey, $value[$indice]->toString(), $this->_where);
									}else{
										array_push($this->_bindParam, array($theKey, $value[$indice], null));
									}
								}
							}else{
								if(is_object($value[$indice])){
									$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value[$indice]->getBindParam());
									$this->_where = str_replace($theKey, $value[$indice]->toString(), $this->_where);
								}else{
									array_push($this->_bindParam, array($theKey, $value[$indice], $typage));
								}
							}
						}
					}else{			
						if($typage !== null){
							if(is_array($typage)){
								if(is_object($value)){
									$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value->getBindParam());
									$this->_where = str_replace($theKey, $value->toString(), $this->_where);
								}else{
									array_push($this->_bindParam, array($theKey, $value, $typage[0]));
								}
							}else{
								if(is_object($value)){
									$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value->getBindParam());
									$this->_where = str_replace($theKey, $value->toString(), $this->_where);
								}else{
									array_push($this->_bindParam, array($theKey, $value, $typage));
								}
							}
						}else{
							if(is_object($value)){
								$this->_bindParam = $this->mergeBindParam($this->_bindParam, $value->getBindParam());
								$this->_where = str_replace($theKey, $value->toString(), $this->_where);
							}else{
								array_push($this->_bindParam, array($theKey, $value, null));
							}
						}
					}
				}
			}
		}
		
		/**
		 * Crée un nouvel objet Core_DbTable_ORM
		 * @param string $champs
		 * @return Core_DbTable_ORM
		 */
		public function select($champs = null){
			
			$newRequest = clone $this;
			$newRequest->_select($champs);

			return $newRequest;
		}
		
		/**
		 * Ecris un SELECT dans la requête SQL
		 * @param string $champs
		 */
		private function _select($champs = null){
			
			$row = '';
			$j=0;
			if($champs != null){
				if(is_array($champs)){
					$i = 0;
					foreach($champs as $key=>$value){
						$j++;
						if($key === $i){
							$i++;
							if($i > 1){
								$row .= ', ';
							}
							$row .= $value.' ';
						}else{
							if($j > 1){
								$row .= ', ';
							}
							$row .= $value.' AS '.$key.' ';
						}
					}
				}else{
					if($this->_select != ''){
						$row .= ', ';
					}
					$row .= $champs.' ';
				}
			}else{ 
				$row = '*';
			}
				
			$this->_select = 'SELECT '.$row.' ';
		}	
		
		/**
		 * Ecris la table de selection
		 * @param string $table
		 * @return Core_DbTable_Select
		 */
		public function from($table = null, $row = null){
			
			$alias = '';
			$nameTable = '';
			
			if($table != null){
				if(is_object($table)){
					$this->_from = 'FROM '.$table->_name.' ';
					$nameTable = $table->_name;
				}else{
					if(is_array($table)){
						if(array_key_exists(0, $table)){
							if(is_object($table[0])){
								$this->_from = 'FROM '.$table[0]->_name.' ';
								$nameTable = $table[0]->_name;
							}else{
								if(stripos($table[0], ' as ') !== false){
									$tableAlias = preg_split('/ as /i', $table[0]);
										
									$this->_from = 'FROM '.$tableAlias[0].' AS '.$tableAlias[1].' ';
									$alias = $tableAlias[1];
									$nameTable = $tableAlias[0];
								}else{
									$this->_from = 'FROM '.$table[0].' ';
									$nameTable = $table[0];
								}
							}
						}else{
							if(is_object($table[key($table)])){
								$this->_from = 'FROM '.$table[key($table)]->_name.' AS '.key($table).' ';
								$alias = key($table);
								$nameTable = $table[key($table)]->_name;
							}else{
								$this->_from = 'FROM '.$table[key($table)].' AS '.key($table).' ';
								$alias = key($table);
								$nameTable = $table[key($table)];
							}
						}
					}else{
						if(stripos($table, ' as ') !== false){
							$tableAlias = preg_split('/ as /i', $table);
							
							$this->_from = 'FROM '.$tableAlias[0].' AS '.$tableAlias[1].' ';
							$alias = $tableAlias[1];
							$nameTable = $tableAlias[0];
						}else{
							$this->_from = 'FROM '.$table.' ';
							$nameTable = $table;
						}
					}
				}
			}else{
				 echo 'Le nom de la table inconnue';
			}
			
			if($row != null){
				if(is_array($row)){
					$i = 0;
					foreach($row as $key=>$value){
						if($key === $i){
							$i++;
							
							if(strpos($value, '.') !== false){
								$this->_select .= ', '.$value.' ';
							}else{
								if($alias != ''){
									$this->_select .= ', '.$alias.'.'.$value.' ';
								}else{
									$this->_select .= ', '.$nameTable.'.'.$value.' ';
								}
							}
						}else{
							$this->_select .= ', '.$value.' AS '.$key.' ';
						}
					}
				}else{
					if(strpos($row, '.') !== false){
						$this->_select .= ', '.$row.' ';
					}else{
						if($alias != ''){
							$this->_select .= ', '.$alias.'.'.$row.' ';
						}else{
							$this->_select .= ', '.$nameTable.'.'.$row.' ';
						}
					}
				}
			}
			
			return $this;
		}
		
		/**
		 * Permet de faire des jointures internes
		 * @param array||string $tableJoin
		 * @param string $on
		 * @param string||array $row
		 * @return Core_DbTable_ORM
		 */
		public function join($tableJoin, $on, $row = null){
			
			$alias = '';
			$nameTable = '';
			
			if($tableJoin != null){
				if($this->_from != ''){
					if(is_array($tableJoin)){
						if(array_key_exists(0, $tableJoin)){
							if(stripos($tableJoin[0], ' as ') !== false){
								$tableAlias = preg_split('/ as /i', $tableJoin[0]);
									
								$this->_join .= 'INNER JOIN '.$tableAlias[0].' AS '.$tableAlias[1].' ';
								$nameTable = $tableAlias[0];
								$alias = $tableAlias[1];
							}else{
								$this->_join .= 'INNER JOIN '.$tableJoin[0].' ';
								$nameTable = $tableJoin[0];
							}
						}else{
							$this->_join .= 'INNER JOIN '.$tableJoin[key($tableJoin)].' AS '.key($tableJoin).' ';
							$nameTable = $tableJoin[key($tableJoin)];
							$alias = key($tableJoin);
						}
					}else{
						if(stripos($tableJoin, ' as ') !== false){
							$tableAlias = preg_split('/ as /i', $tableJoin);
						
							$this->_join .= 'INNER JOIN '.$tableAlias[0].' AS '.$tableAlias[1].' ';
							$nameTable = $tableAlias[0];
							$alias = $tableAlias[1];
						}else{
							$this->_join .= 'INNER JOIN '.$tableJoin.' ';
							$nameTable = $tableJoin;
						}
					}
				}else{
					$this->_error = 'Nom de table de jointure inconnue';
				}
			}else{
				$this->_error = 'Le nom de la table inconnue';
			}
			
			if($on != null){
				$this->_join .= 'ON '.$on.' ';
			}
			
			if($row != null){
				if(is_array($row)){
					$i = 0;
					foreach($row as $key=>$value){
						if($key === $i){
							$i++;
							if(strpos($value, '.') !== false){
								$this->_select .= ', '.$value.' ';
							}else{
								if($alias != ''){
									$this->_select .= ', '.$alias.'.'.$value.' ';
								}else{
									$this->_select .= ', '.$nameTable.'.'.$value.' ';
								}
							}
						}else{
							$this->_select .= ', '.$value.' AS '.$key.' ';
						}
					}
				}else{
					if(strpos($row, '.') !== false){
						$this->_select .= ', '.$row.' ';
					}else{
						if($alias != ''){
							$this->_select .= ', '.$alias.'.'.$row.' ';
						}else{
							$this->_select .= ', '.$nameTable.'.'.$row.' ';
						}
					}
				}
			}
			
			return $this;
		}
		
		/**
		 * Stocke les champs et les valeurs de la condition where (AND)
		 * @param string $condition
		 * @param string $value
		 * @return Core_DbTable_Select
		 */
		public function where($condition, $value, $typage = null){
			if($this->_where != 'WHERE' && $this->_where != ''){
				$this->_where .= 'AND';
			}
			
			if($this->_where == ''){
				$this->_where = 'WHERE';
			}
			
			$this->_where .= ' (';
			$this->_where .= $condition;
			$this->_where .= ') ';
			
			$this->bindParam($condition, $value, $typage);
			return $this;
		}
		
		/**
		 * Stocke les champs et les valeurs de la condition where (OR)
		 * @param string $condition
		 * @param string $value
		 * @return Core_DbTable_Select
		 */
		public function orWhere($condition, $value){
			if($this->_where != ''){
				$this->_where .= 'OR';
			}
			
			$this->_where .= ' (';
			$this->_where .= $condition;
			$this->_where .= ') ';
			
			$this->bindParam($condition, $value);
			return $this;
		}
		
		/**
		 * Assigne un ordre a la requête
		 * @param string $order
		 * @return Core_DbTable_Select
		 */
		public function order($order){
			$this->_order = ' ORDER By '.$order;
			
			return $this;
		}
		
		/**
		 * Met une limite à la reqête
		 * @param integer $begin
		 * @param integer $nb
		 */
		public function limit($begin, $nb){
			$this->_limit = ' LIMIT :beginLimit, :nbLimit';
			
			array_push($this->_bindParam, array(':beginLimit', $begin, 'int'));
			array_push($this->_bindParam, array(':nbLimit', $nb, 'int'));
			
			return $this;
		}
		
		/**
		 * Execute une requête fetch
		 * @param string $query
		 * @return mixed
		 */
		public function fetch($query = null){
			
			if($query === null){
				$query = $this->toString();
			}
			
			$sql = $this->_bdd->prepare($query);
			
			foreach($this->_bindParam as $bind){
				$sql->bindParam($bind[0], $bind[1], $this->getPDOParam($bind[2]));
			}
			
			$sql->setFetchMode(PDO::FETCH_CLASS, get_class($this));
			$sql->execute();
		
		
			return $sql->fetch();
		}
		
		/**
		 * Execute une requête fetchAll
		 * @param string $query
		 * @return mixed
		 */
		public function fetchAll($query = null){
				
			if($query === null){
				$query = $this->toString();
			}

			$sql = $this->_bdd->prepare($query);
			foreach($this->_bindParam as $bind){
				$sql->bindParam($bind[0], $bind[1], $this->getPDOParam($bind[2]));
			}

			$sql->setFetchMode(PDO::FETCH_CLASS, get_class($this));
			$sql->execute();
		
			return $sql->fetchAll();
		}
		
		/**
		 * Récupère un enregistrement par rapport à la clé primaire
		 * @param string $valuePrimary
		 * @return mixed
		 */
		public function find($valuePrimary){
			
			$sql = $this->_bdd->prepare('SELECT * FROM '.$this->_name.' WHERE '.$this->_primary.' = :primary');
			
			$sql->bindParam(':primary', $valuePrimary, $this->getPDOParam($this->describeColumn($this->_primary), 'strpos'));
			$sql->setFetchMode(PDO::FETCH_CLASS, get_class($this));
			$sql->execute();
			
			return $sql->fetch();
		}
		
		/**
		 * Crée un objet pour l'insertion
		 * @return Models_Test
		 */
		public function create(){
			$newModel = clone $this;
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
			
			$describe = $this->describeTable();
			
			foreach($props as $key=>$value){	
				if(!in_array($key, $this->_arrayProp)){
					$i++;

					if($this->_action == ''){
						if($key == $this->_primary){
							array_push($this->_bindParamSave, array(':primary', $value, $describe[$key]));
						}else{
							array_push($this->_bindParamSave, array(':param'.$i, $value, $describe[$key]));
						}
					}else{
						array_push($this->_bindParamSave, array(':param'.$i, $value, $describe[$key]));	
					}
					
					if($this->_action == 'insert'){
						$rows .= $key;
						$insertValue .= ':param'.$i;
						
						if((count($props) - count($this->_arrayProp)) > $i){
							$rows .= ', ';
							$insertValue .= ', ';
						}
					}else{
						if($key == $this->_primary){
							$id = $this->_primary.' = :primary';
						}else{
							$query .= $key.' = :param'.$i;
							if((count($props) - count($this->_arrayProp)) > $i){
								$query .= ', ';
							}
						}
					}
				}
			}

			if($this->_action == 'insert'){
				$sql = $this->_bdd->prepare('INSERT INTO '.$this->_name.' ('.$rows.') VALUES ('.$insertValue.')');
			}else{
				$sql = $this->_bdd->prepare('UPDATE '.$this->_name.' SET '.$query.' WHERE '.$id);
			}
				
			foreach($this->_bindParamSave as $bind){
				$sql->bindParam($bind[0], $bind[1], $this->getPDOParam($bind[2], 'strpos'));
			}
			$sql->execute();
			
			if($this->_action == 'insert'){
				return $this->_bdd->lastInsertId();
			}
		}
		
		/**
		 * Execute une requête DELETE
		 * @param string $condition
		 * @param string $value
		 * @return boolean
		 */
		public function delete($condition, $value = null, $typage = null){
			
			if($value === null){
				$sql = $this->_bdd->prepare('DELETE FROM '.$this->_name.' WHERE '.$this->_primary.' = :primary');
				$type = $this->getPDOParam($this->describeColumn($this->_primary), 'strpos');
				
				$sql->bindParam(':primary', $condition, $type);
				return $sql->execute();
			}else{
				$sql = $this->_bdd->prepare('DELETE FROM '.$this->_name.' WHERE '.$condition);
				$this->bindParam($condition, $value, $typage);
				
				foreach($this->_bindParam as $bind){
					$sql->bindParam($bind[0], $bind[1], $this->getPDOParam($bind[2]));
				}
				return $sql->execute();
			}
			
		}
		
		/**
		 * Récupére les types des champs de la table principale
		 * @return array
		 */
		private function describeTable(){
			$sql = $this->_bdd->prepare('DESCRIBE '.$this->_name);
			$sql->execute();
			
			$res = $sql->fetchAll(PDO::FETCH_OBJ);
			$tabDescribe = array();
			foreach($res as $describe){
				$tabDescribe[$describe->Field] = $describe->Type;
			}
			
			return $tabDescribe;
		}
		
		/**
		 * Récupére les types des champs de la table principale
		 * @return array
		 */
		private function describeColumn($column){
			$sql = $this->_bdd->prepare('DESCRIBE '.$this->_name.' '.$column);
			$sql->execute();	
			$res = $sql->fetch(PDO::FETCH_OBJ);
			
			return $res->Type;
		}
		
		/**
		 * Retourne les clés de la condition where
		 * @return multitype:
		 */
		public function getBindParam(){
			return $this->_bindParam;
		}
		
		/**
		 * Modifie l'action des requêtes (insert ou update)
		 * @param string $action
		 */
		private function setAction($action){
			$this->_action = $action;
		}
		
		/**
		 * Fusionne deux tableaux bindParam;
		 * @param array $array1
		 * @param array $array2
		 * @return array
		 */
		private function mergeBindParam($array1, $array2){
			foreach($array2 as $key=>$value){
				array_push($array1, $value);
			}
				
			return $array1;
		}
		
		/**
		 * Retoune le PDO::Param selon le type
		 * @param string $bind
		 * @param string $function
		 * @return number|NULL
		 */
		private function getPDOParam($bind, $function = null){
			if($function !== null && $function == 'strpos'){
				if(strpos($bind, 'char') !== false || strpos($bind, 'text') !== false){
					return PDO::PARAM_STR;
				}elseif(strpos($bind, 'int') !== false){
					return PDO::PARAM_INT;
				}else{
					return null;
				}
			}else{
				switch($bind[2]){
					case 'int' : return PDO::PARAM_INT;break;
					case 'str' : return PDO::PARAM_STR;break;
					default: return null;
				}
			}
		}
		
		/**
		 * Ecris la requête
		 * @return string
		 */
		public function toString(){
			
			$select = $this->_select;
			$from = $this->_from;
			$join = $this->_join;
			$where = $this->_where;
			$order = $this->_order;
			$limit = $this->_limit;
			
			if($where == 'WHERE'){
				$where = '';
			}
			
			return $select.$from.$join.$where.$order.$limit;
		}
	}