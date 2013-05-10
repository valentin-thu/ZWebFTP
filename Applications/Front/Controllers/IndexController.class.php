<?php

class Applications_Front_Controllers_IndexController extends Core_Controllers{
	
	public function init(){
		$this->headLink()->appendFile('sqdsqd.css')->appendFile('plop.css');
		$this->headScript()->appendFile('sqdsqd.js');
		$this->headTitle()->setTitle('Init');
	}
	
	public function indexAction(){
		
		//echo $this->getRequest()->getParam('id');

		$form = new Core_Form();
		$form->setMethod('POST');
		$form->setAttrib('class', 'formLog');
		
		$login = new Core_Form_Element_Text('login');
		$login->setAttrib('class', 'classLogin');
		$login->setAttrib('placeholder', 'Votre login');
		$login->addValidator('Email');
		
		$pass = new Core_Form_Element_Text('pass');
		$pass->setAttrib('class', 'classPass');
		$pass->setValue('Mon pass');
		
		$check = new Core_Form_Element_Checkbox('cookie');
		$check->addMultiOption('oui', 'Se souvenir de moi');
		$check->addMultiOption('non', 'Pas Se souvenir de moi');

		
		$submit = new Core_Form_Element_Submit('envoyer');
		$submit->setValue('Envoyer');
		
		$form->addElement($login);
		$form->addElement($pass);
		$form->addElement($submit);
		$form->addElement($check);
		
		
		if($this->getRequest()->hasParam('login')){
			if($form->isValid()){
				echo 'oui';
			}else{
				echo $form->populate();
			}
		}else{
			echo $form->render();
		}
		
		$this->assign('plop', 'testpLop');


		/*$db = new Core_DbTable_Select();
		$db->where('(login = :logion', 'plop')
		   ->where('pass = :pass AND mail = :mail)', array('sdf', 'dgfdg'))
		   ->orWhere('pqsd = :sdf', 'dfdf');		
		//$sdf = $dsfsdf->where('login = :logion AND pass = :password AND sdd = :dfgg', array($login, $pass, $xwc));
		
		//getKey('login = :logion AND pass = :password AND sdd = :dfgg');
		echo '<pre>';
		echo print_r($db->getWhere());
		echo '</pre>';
		echo '<pre>';
		echo print_r($db->getTabKey());
		echo '</pre>';*/
	}
	
	public function errorAction(){
		echo 'plop';
	}
	
}