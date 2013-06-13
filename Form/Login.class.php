<?php 
	
	/**
	 * Crée un formulaire de connexion
	 * @author Valentin
	 *
	 */
	class Form_Login extends Core_Form{
		
		public function __construct(){
			$this->init();
		}
		
		public function init(){
			$eLogin = new Core_Form_Element_Text('login');
			$ePassword = new Core_Form_Element_Password('password');
			$eSouvenir = new Core_Form_Element_Checkbox('souvenir');
			$eSubmit = new Core_Form_Element_Submit('connexion');
			
			$eLogin->setAttrib('placeholder', 'Votre pseudonyme');
			$eLogin->setAttrib('class', 'Login-formLogin-input Login-formLogin-login');
			$eLogin->addValidator('Required');
			
			$ePassword->setAttrib('placeholder', 'Votre mot de passe');
			$ePassword->setAttrib('class', 'Login-formLogin-input Login-formLogin-password');
			$ePassword->addValidator('Required');
			//$ePassword->addValidator('DbLogin', $eLogin);
			
			$eSouvenir->addMultiOption('oui', 'Se souvenir de moi');
			
			$eSubmit->setAttrib('class', 'Login-formLogin-btn');
			$eSubmit->setValue(' ');
			
			$this->setAction('');
			$this->setMethod('POST');
			$this->setAttrib('class', 'Login-formLogin');
			$this->addDecorator('Decorators_FormLogin');
			
			$this->addElement($eLogin);
			$this->addElement($ePassword);
			$this->addElement($eSouvenir);
			$this->addElement($eSubmit);
		}
		
	}