<?php

class Applications_Login_Controllers_IndexController extends Core_Controllers{
	
	public function init(){
		$this->headTitle()->setTitle('Connexion à ZWebFTP');
	}
	
	public function indexAction(){
		$this->headLink()->appendFile('http://fonts.googleapis.com/css?family=Aladin');
		
		$formLogin = new Form_Login();
		
		if($this->getRequest()->hasParam('login')){
			
		}else{
			$this->assign('formLogin', $formLogin);
		}
		
	}
	
	
	
}