<?php 

class Core_Dispatcher{
	protected $_uri;
	protected $_view;
	protected $_controller;
	protected $_layout;
	protected $_vars;
	protected $_appli;
	protected $_role;
	protected $_headLink;
	protected $_headScript;
	protected $_headTitle;
	protected $_headMeta;
	protected $_headDoctype;
	
	public function getRole(){
		return $this->_role;
	}
	
	public function getView(){
		return $this->_view;
	}
	
	public function getAppli(){
		return $this->_appli;
	}
	
	public function getLayout(){
		return $this->_layout;
	}
	
	public function getController(){
		return $this->_controller;
	}
	
	public function getVars(){
		return $this->_vars;
	}
	
	public function headLink(){
		return $this->_headLink;
	}
	
	public function headScript(){
		return $this->_headScript;
	}
	
	public function headTitle(){
		return $this->_headTitle;
	}
	
	public function headMeta(){
		return $this->_headMeta;
	}
	
	public function headDoctype(){
		return $this->_headDoctype;
	}
	
	public function getRoutes(){
		
		$appli = $controller = $action = null;
		$file = '../Applications/routes.xml';
		if(!file_exists($file)){
			throw new Exception('Le fichier de routes de l\'application <strong>'.$this->_appli.'</strong> n\'existe pas.');
		}
			
		if($this->_uri == BASE){
			$controller = 'Index';
			$action = 'index';
			$role = array(0);
		}else {
			$XML = new Core_XML($file);
			foreach($XML->getXml() as $route){
				$uri = $route->attributes()->uri;
			
				if(preg_match('`^'.''.BASE.'/'.$uri.'$`', $this->_uri, $matches)){		
					$role = explode(',', $route->attributes()->role);
					$controller = $route->attributes()->controller;
					$action = $route->attributes()->action;
					if(isset($route->attributes()->module) && !empty($route->attributes()->module)){
						$this->_appli = $route->attributes()->module;
					}
					
					//Ajout des variables de l'uri dans les variables $_GET
					if(isset($route->attributes()->var)){
						$vars = explode(',', $route->attributes()->var);
						foreach($matches as $key => $matche){
							if($key !== 0){
								$_GET[$vars[$key - 1]] = $matche;
							}
						}
					}
					break;
				}			
			}
		}
		
		
		
		if((empty($action) && empty($controller)) || !in_array($this->_role, $role) ){
			$controller = 'Index';
			$action = 'error';			
		}
		
		//Instance du controller en fonction de la page demandée + appel de l'action
		$class = 'Applications_'.$this->_appli.'_Controllers_'.$controller.'Controller';
		$method = $action.'Action';
		$Controller = new $class();
		
		$bootstrapName = 'Applications_'.$this->_appli.'_Bootstrap';
		$Bootstrap = new $bootstrapName();
		
		foreach(get_class_methods($Bootstrap) as $initFunction){
			if(preg_match('#^_init#', $initFunction)){
				$Bootstrap->$initFunction();
			}
		}
		
		if(method_exists($Controller, 'init')){
			$Controller->init();
		}
		
		$Controller->$method();
		
		//Charge le layout spécifique si besoin
		if($Controller->hasLayout()){
			$this->_layout = $Controller->getLayout();
		}else{
			$this->_layout = $this->_appli;
		}
		
		$called = get_called_class();
		$called->setLayout($this->_layout);
		
		//Charge les variables à transmettre à la vue
		if($Controller->hasVars()){
			$this->_vars = $Controller->getVars();
		}
		
		$this->setVars($this->_vars);
		
		//$this->_headLink = Core_Registry::get('headLink', 'HEAD');
		
		
		$headScriptBootstrap = $Bootstrap->headScript()->getFiles();
		$headScriptController = $Controller->headScript()->getFiles();
		$newArrayHeadScript = $headScriptBootstrap;
		
		$newHeadScript = new Core_Layout_HeadScript();
		foreach($headScriptController as $script){
			if(!in_array($script, $newArrayHeadScript)){
				array_push($newArrayHeadScript, $script);
			}
		}
		
		$newHeadScript->setFiles($newArrayHeadScript);
		$this->_headScript = $newHeadScript;
	
		if($Controller->headTitle()->hasTitle()){
			$this->_headTitle = $Controller->headTitle();
		}else{
			$this->_headTitle = $Bootstrap->headTitle();
		}
		
		$headMetaBootstrap = $Bootstrap->headMeta()->getMetas();
		$headMetaController = $Controller->headMeta()->getMetas();
		$newArrayHeadMeta = $headMetaBootstrap;
		
		$newHeadMeta = new Core_Layout_HeadMeta();
		if(is_array($headMetaController)){
			foreach($headMetaController as $meta){
				if(!in_array($meta, $newArrayHeadMeta)){
					array_push($newArrayHeadMeta, $meta);
				}
			}
		}
		
		$newHeadMeta->setMetas($newArrayHeadMeta);
		$this->_headMeta = $newHeadMeta;
		
		
		if($Controller->headDoctype()->hasDoctype()){
			$this->_headDoctype = $Controller->headDoctype();
		}else{
			$this->_headDoctype = $Bootstrap->headDoctype();
		}
		
		
		$this->_view = $action;
		$this->_controller = $controller;
		
		$this->setView($this->_appli, $this->_controller, $this->_view);
	}
	
}