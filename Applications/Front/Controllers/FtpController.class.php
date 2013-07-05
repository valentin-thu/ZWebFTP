<?php

class Applications_Front_Controllers_FtpController extends Core_Controllers{
		
	/**
	 * Affiche le formulaire
	 */
	public function connexionAction(){
		
		$this->noRenderer(true, false);
		
		$formFTP = new Form_Ftpconnexion();
		$this->assign('formFTP', $formFTP);
	}
	
	/**
	 * Affiche le formulaire lors d'un appel avec AJAX
	 */
	public function ajaxconnexionAction(){
		
		$this->noRenderer(false);
		
		$formFTP = new Form_Ftpconnexion();
		
		if($this->getRequest()->hasParam('hote')){
			if($formFTP->isValid()){
				$elts = (object)$formFTP->getElements();
				
				$hote = $elts->hote->getValue();
				$port = $elts->port->getValue();
				$login = $elts->login->getValue();
				$password = $elts->password->getValue();
				
				$ftp = new Core_FTP($hote, $port, $login, $password);
				Core_Sessions::set('ftp', $ftp, 'FTP');				
				
			}else{
				echo $formFTP->populate();
			}
		}else{
			echo $formFTP;
		}
		
	}
	
	public function ajaxexplorerAction(){
		$this->noRenderer(false);
		
		if($this->getRequest()->hasParam('data')){
			$data = $this->getRequest()->getParam('data');
		}else{
			$data = null;
		}
		
		if(Core_Sessions::get('ftp', 'FTP') !== null){
			$ftp = Core_Sessions::get('ftp', 'FTP');
			$ftp->connect();
			$ftp->nlistExplorer(urldecode($this->getRequest()->getParam('dir')), $data);
			$ftp->close();
			echo $ftp->getList();
		}
	}
	
	public function ajaxfilesAction(){
		$this->noRenderer(false);
		
		if(Core_Sessions::get('ftp', 'FTP') !== null){
			$ftp = Core_Sessions::get('ftp', 'FTP');
			$ftp->connect();
			$ftp->nlistFiles(urldecode($this->getRequest()->getParam('dir')));
			$ftp->close();
			echo $ftp->getList();
		}
	}
	
}