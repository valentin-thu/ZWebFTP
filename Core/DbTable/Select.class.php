<?php

	/**
	 * Crée les requête SELECT
	 * @author Valentin
	 *
	 */
	class Core_DbTable_Select{	
		protected $_order;
		protected $_select;
		protected $_from;
		protected $_error;
		protected $_where = '';
		protected $_tabKey = array();
		
		/**
		 * Stocke les clés des conditions
		 * @param string $condition
		 * @param string $value
		 * @param number $indice
		 */
		public function getKey($condition, $value, $indice = 0){
			$markKey = ':';
			if(strpos($condition, $markKey)){
				$debutKey = strpos($condition, $markKey) + strlen($markKey);
				$ssCondition = substr($condition, $debutKey);
				if(strpos($ssCondition, ' ')){
					if(is_array($value)){
						$this->_tabKey[str_replace(array('(', ')'), array(''), strstr($ssCondition, ' ', true))] = $value[$indice];
					}
					$this->getKey(strstr($ssCondition, ' '), $value, ++$indice);
				}else{
					if(is_array($value)){
						$this->_tabKey[str_replace(array('(', ')'), array(''), $ssCondition)] = $value[$indice];
					}else{
						$this->_tabKey[str_replace(array('(', ')'), array(''), $ssCondition)] = $value;
					}
				}
			}
		}
		
		/**
		 * Ecris les champs de selection
		 * @param string $champs
		 * @return Core_DbTable_Select
		 */
		public function select($champs = null){
			if($champs != null){
				if(is_array($champs)){
					$champs = implode(',', $champs);
				}
			}else{
				$champs = '*';
			}
			
			$this->_select = 'SELECT '.$champs.' ';
			
			return $this;
		}
		
		/**
		 * Ecris la table de selection
		 * @param string $table
		 * @return Core_DbTable_Select
		 */
		public function from($table){
			if($table != null){
				$this->_from = $table.' ';
			}else{
				$this->_error = 'Le nom de la table inconnue';
			}
			
			return $this;
		}
		
		/**
		 * Stocke les champs et les valeurs de la condition where (AND)
		 * @param string $condition
		 * @param string $value
		 * @return Core_DbTable_Select
		 */
		public function where($condition, $value){
			
			if($this->_where != ''){
				$this->_where .= 'AND';
			}
			
			$this->_where .= ' (';
			$this->_where .= $condition;
			$this->_where .= ') ';
			
			$this->getKey($condition, $value);
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
			
			$this->getKey($condition, $value);
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
		 * Retourne la condition where
		 * @return string
		 */
		public function getWhere(){
			return $this->_where;
		}
		
		/**
		 * Retourne les clés de la condition where
		 * @return multitype:
		 */
		public function getTabKey(){
			return $this->_tabKey;
		}
	}