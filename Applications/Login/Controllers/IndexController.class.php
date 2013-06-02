<?php

class Applications_Login_Controllers_IndexController extends Core_Controllers{
	
	public function init(){
		$this->headTitle()->setTitle('Connexion à ZWebFTP');
	}
	
	public function indexAction(){
		$this->headLink()->appendFile('http://fonts.googleapis.com/css?family=Aladin');
		
		$formLogin = new Form_Login();
		
		if($this->getRequest()->hasParam('login')){
			if($formLogin->isValid()){
				echo 'oui';
			}else{
				echo $this->assign('formLogin', $formLogin->populate());
			}
		}else{
			$this->assign('formLogin', $formLogin);
		}
		
	}
	
	
	
}