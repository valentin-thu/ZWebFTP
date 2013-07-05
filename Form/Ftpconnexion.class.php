<?php 
	
	/**
	 * Crée un formulaire de connexion
	 * @author Valentin
	 *
	 */
	class Form_Ftpconnexion extends Core_Form{
		
		public function __construct(){
			$this->init();
		}
		
		public function init(){
			$eHote = new Core_Form_Element_Text('hote');
			$ePort = new Core_Form_Element_Text('port');
			$eLogin = new Core_Form_Element_Text('login');
			$ePassword = new Core_Form_Element_Password('password');
			
			$eHote->setAttrib('placeholder', 'L\'hôte');
			$eHote->addValidator('Required');
			$eHote->setAttrib('style', 'width:90%;');
			
			$ePort->setAttrib('placeholder', 'Port');
			$ePort->addValidator('Required');
			$ePort->addValidator('Maxlength', 5);
			$ePort->addValidator('Integer');
			$ePort->setAttrib('style', 'width:80%;');
			$ePort->setAttrib('maxlength', 5);
			$ePort->setAttrib('data-filter', 'integer');
			$ePort->setValue(21);
			
			$eLogin->setAttrib('placeholder', 'Utilisateur');
			$eLogin->addValidator('Required');
			$eLogin->setAttrib('style', 'width:90%;');
			
			$ePassword->setAttrib('placeholder', 'Mot de passe');
			$ePassword->addValidator('Required');
			$ePassword->setAttrib('style', 'width:93%;');
			
			$this->setAction('');
			$this->setMethod('POST');
			$this->setAttrib('id', 'FormFTPConnexion');
			$this->addDecorator('Decorators_FormFTPConnexion');
			
			$this->addElement($eHote);
			$this->addElement($ePort);
			$this->addElement($eLogin);
			$this->addElement($ePassword);
		}
		
	}