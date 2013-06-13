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
				$auth = new Core_Auth('zwebftp_users', 'login_users', 'password_users');
				$elts = (object)$formLogin->getElements();
				
				$auth->setIdentitys($elts->login->getValue(), $elts->password->getValue());
				
				if($auth->isValid() === true){
					$this->redirect('accueil.html');
				}else{
					$formLogin->getElement('password')->setError($auth->isValid());
					echo $this->assign('formLogin', $formLogin->populate());
				}
			}else{
				echo $this->assign('formLogin', $formLogin->populate());
			}
		}else{
			$this->assign('formLogin', $formLogin);
		}
		
	}
	
	
	
}