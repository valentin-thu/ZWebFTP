<?php
	
	class Models_Test extends Core_DbTable_ORM{
		
		public $_name = 'test';
		public $_primary = 'id';
		
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
			$req = $this->select()
						->from($this);
			
			return $req->fetchAll();
		}
		
		public function testFrom2(){
			$plop = $this->select()
						->from(array('qqsdsd AS plop'), array('qsdazqsdaze2' => 'qsd', 'sqdqsd'))
						->join('Ville', 'vil.id = sd.id', array('qsd', 'plo'=>'sqdsqd'))
						->where(' sdqsd = :sd  AND  plop = :rez AND qsd ', array('sdsd', 'pspdl'), array('str', 'int'));
			
			return $plop;
		}
		
		public function testFrom(){
			
			$req = $this->select()
						->from('plop')
						->where('id = :id', '5', 'int');
			
			$plop = $this->select(array('sqdfd', 'szrr'))
						->from(array('qsd AS plop'), array('qsdqsdaze2' => 'qsd', 'sqdqsd'))
						->join('Ville', 'vil.id = sd.id', array('qsd', 'plo'=>'sqdsqd'))
						->where(' sdqsd = :sd  AND  plop = :rez AND qsd NOT IN(:in) ', array('sdsd', 'pspdl', $req), array('str'));
			$req->getBindParam();
			return $plop;
		}
		
		public function current(){
			return $this->_rows[0];
		}
		
		public function vars(){
			
			return get_object_vars($this);
		}
		
		
	}