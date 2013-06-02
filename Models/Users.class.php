<?php
	
	class Models_Users extends Core_DbTable_ORM{
		
		public $_name = 'users';
		public $_primary = 'id_users';
		
		public function getPasswordByLogin($login){
			$req = $this->select('password_users')
						->from($this)
						->where('login_users = :login', $login, 'str');

			return $req->fetch();
		}
		
	}