<?php 
	
	/**
	 * Charge l'application en fonction du controller, view, template
	 * @author Valentin
	 *
	 */
	class Core_Layout extends Core_Init{
		protected $_uri;
		protected $_view;
		protected $_controller;
		protected $_layout;
		protected $_vars;
		protected $_appli;
		protected $_role;
		protected $_renderer = false;
		protected $_rendererLayout = false;
		
		public function __construct($appli){
			$this->_appli = $appli;
			$this->_uri = $_SERVER['REQUEST_URI'];
			
			$identity = Core_Sessions::get('identity', 'AUTH');
			if($identity != null){
				$this->_role = $identity->getStorage()->id_groups;	
			}else{
				$this->_role = 1;
			}
			
			parent::__construct();
		}
		
		/**
		 * Modifie le layout en fonction du fichier
		 * @param string $layout
		 * @throws exception
		 */
		public function setLayout($layout){
			$file = '../Applications/Templates/'.$layout.'.phtml';
			if(!file_exists($file)){
				throw new exception(sprintf('Le fichier de template n\'existe pas : %s', $file));
			}
			$this->_layout = $file;
		}
		
		/**
		 * Modifie la vue en fonction du template, controller, vue 
		 * @param string $appli
		 * @param string $controller
		 * @param string $view
		 * @throws exception
		 */
		public function setView($appli, $controller, $view){
			$file = '../Applications/'.$appli.'/Views/'.$controller.'/'.$view.'.phtml';
			if(!file_exists($file)){
				throw new exception(sprintf('Le fichier de vue n\'existe pas : %s', $file));
			}
			$this->_view = $file;
		}
		
		/**
		 * Charge les variables vers la vue
		 * @param array $vars
		 */
		public function setVars($vars){
			if(is_array($vars)){
				$this->_vars = $vars;
			}else{
				$this->_vars = array();
			}
		}
		
		/**
		 * Initialise les différentes variables nécessaire à l'application en fonction de la route XML
		 * @throws Exception
		 */
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

			if((empty($action) && empty($controller)) || !in_array($this->_role, $role)){
				$controller = 'Index';
				$action = 'error';
			}
		
			//Instance du controller en fonction de la page demandée + appel de l'action
			$class = 'Applications_'.$this->_appli.'_Controllers_'.$controller.'Controller';
			$method = $action.'Action';
			$Controller = new $class();
			
			$bootstrapName = 'Applications_Bootstrap';
			$Bootstrap = new $bootstrapName();
			
			foreach(get_class_methods($Bootstrap) as $initFunction){
				if(preg_match('#^_init#', $initFunction)){
					$Bootstrap->$initFunction();
				}
			}
			
			$bootstrapNameApp = 'Applications_'.$this->_appli.'_Bootstrap';
			$BootstrapApp = new $bootstrapNameApp();
		
			foreach(get_class_methods($BootstrapApp) as $initFunctionApp){
				if(preg_match('#^_init#', $initFunctionApp)){
					$BootstrapApp->$initFunctionApp();
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
		
			if($Controller->isRendererLayout()){
				$this->_rendererLayout = true;
				$this->setLayout($this->_layout);
			}

			//Charge les variables à transmettre à la vue
			if($Controller->hasVars()){
				$this->_vars = $Controller->getVars();
			}
		
			$this->setVars($this->_vars);
		
			//Initialise les objets du Header
			$this->_headLink = Core_Registry::get('headLink', 'HEAD');
			$this->_headScript = Core_Registry::get('headScript', 'HEAD');
			$this->_headTitle = Core_Registry::get('headTitle', 'HEAD');
			$this->_headMeta = Core_Registry::get('headMeta', 'HEAD');
			$this->_headDoctype = Core_Registry::get('headDoctype', 'HEAD');	
		
			$this->_view = $action;
			$this->_controller = $controller;
			
			if($Controller->isRenderer()){
				$this->_renderer = true;
				$this->setView($this->_appli, $this->_controller, $this->_view);
			}
			
			
		}
		
		
		/**
		 * Charge un partial
		 * @param string $namePartial
		 * @param string $controller
		 * @param string $action
		 * @return string
		 */
		public function partial($namePartial, $appli = null){
			
			$appliDir = ($appli != null) ? $appli : $this->_appli;
			
			ob_start();
			require_once '../Applications/'.$appliDir.'/Partials/'.$namePartial.'.phtml';
			$partial = ob_get_clean();
			
			return $partial;
		}
		
		/**
		 * Charge une actionavec sa vue
		 * @param string $namePartial
		 * @param string $controller
		 * @param string $action
		 * @return string
		 */
		public function action($action, $controller){
				
			if($controller != null && $action != null){
				$nameController = 'Applications_Front_Controllers_'.$controller.'Controller';
				$Controllers = new $nameController();
		
				$nameMethod = $action.'Action';
				$Controllers->$nameMethod();
		
				$var = $Controllers->getVars();
				if(is_array($var)){
					extract($var);
				}
			}
				
			ob_start();
			require_once '../Applications/'.$this->_appli.'/Views/'.$controller.'/'.$action.'.phtml';
			$actions = ob_get_clean();
				
			return $actions;
		}
		
		/**
		 * Affiche l'application entière
		 */
		public function create(){
			$this->getRoutes();	
			extract($this->_vars);
			
			//Charge et garde en mémoire le contenu de la vue
			//ob_start();
			
			if($this->_renderer == true){
				require_once $this->_view;
				if($this->_rendererLayout == true){
					$content = ob_get_clean();
					require_once $this->_layout;
				}
			}
	        
	        //Charge le layout où il y a le content de la vue
	       // ob_start();      
	        
		}
	}