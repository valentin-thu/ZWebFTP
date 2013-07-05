<?php

class Applications_Front_Controllers_IndexController extends Core_Controllers{
	
	public function init(){
		$this->headTitle()->setTitle('Bienvenue dans ZWebFTP');
	}
	
	public function indexAction(){
		
		if(Core_Sessions::get('ftp', 'FTP') !== null){
			$ftp = Core_Sessions::get('ftp', 'FTP');
			$ftp->connect();
			$ftp->nlistFiles();
			$ftp->close();
			$this->assign('files', $ftp->getList());
		}else{
			$this->assign('files', '');
		}
		
	}
	
	public function menuAction(){
		if(Core_Sessions::get('ftp', 'FTP') !== null){
			$ftp = Core_Sessions::get('ftp', 'FTP');
			$ftp->connect();
			$ftp->nlistExplorer();
			$ftp->close();
			$this->assign('menu', $ftp->getList());
		}else{
			$this->assign('menu', '');
		}
	}
	
	public function errorAction(){
	//	echo 'plop';
	}
	
}