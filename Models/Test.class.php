<?php
	
	class Models_Test extends Core_DbTable_ORM{
		/*public $id;
		public $lib;
		
		public function getid(){
			return $this->id;
		}
		
		public function getlib(){
			return $this->lib;
		}*/

		//private $_rows;
		
		public function test(){
			
			return $this->fetch('SELECT * FROM test WHERE id = 1');
			/*$query = 'SELECT * FROM test WHERE id = 1';
			$sql = $this->bdd->prepare($query);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Models_Test');
			$sql->execute();
			
			
			$this->_rows = $sql->fetch();*/
			//return $this->_rows;
		}
		
		public function current(){
			return $this->_rows[0];
		}
		
		public function vars(){
			
			return get_object_vars($this);
		}
		
		
	}