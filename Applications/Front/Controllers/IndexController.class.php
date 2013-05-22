<?php

class Applications_Front_Controllers_IndexController extends Core_Controllers{
	
	public function init(){
		$this->headLink()->appendFile('sqdsqd.css')->appendFile('plop.css');
		$this->headScript()->appendFile('sqdsqd.js');
		$this->headTitle()->setTitle('Init');
	}
	
	public function indexAction(){
		
		$testTa = new Models_Test();
		$test1 = $testTa->test();
		
		
		
		/*$newRow = $testTa->create();
		$newRow->lib = 'plop';
		Core_Debug::print_r($newRow);*/
		//$newRow->save();
		
		
		//$test1->lib = 'update';
		//Core_Debug::print_r($test1->lib);
		//Core_Debug::print_r($test1->vars());
		//$test1->save();
		foreach($test1 as $row){
			Core_Debug::dump($row);
		//$row->lib = 'plopy';
		}
		/*
		Core_Debug::dump($row->lib);
		Core_Debug::print_r($testTa->vars());*/
		
		/*$class = new ReflectionClass('ma_classe');
		$instance = $class->newInstance();
		
		Core_Debug::print_r($instance);*/
		
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
		
		Core_Debug::print_rJS($form);
		
		
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

		
	/*	$db = new Core_DbTable_Select();
		$db->where('login = :logion', 'plop')
		   ->where('pass = :pass AND mail = :mail', array('sdf', 'dgfdg'))
		   ->orWhere('(pqsd = :sdf', 'dfdf')
		   ->orWhere('pqsd = :sdf)', 'dfdf');*/
		

		//$sdf = $dsfsdf->where('login = :logion AND pass = :password AND sdd = :dfgg', array($login, $pass, $xwc));
		
		//getKey('login = :logion AND pass = :password AND sdd = :dfgg');
		/*echo '<pre>';
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