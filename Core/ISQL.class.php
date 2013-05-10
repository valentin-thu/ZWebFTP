<?php 

	interface Core_ISQL{
		public function __construct();
		static function getInstance();
		public function connect();	
	}