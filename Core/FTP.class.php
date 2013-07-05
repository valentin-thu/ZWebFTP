<?php 
	
	/**
	 * Class permettant l'accés et les manipulations des connexions FTP 
	 * @author Valentin
	 *
	 */
	class Core_FTP {
		
		private $_host;
		private $_port;
		private $_login;
		private $_password;
		private $_connexion;
		
		private $_listeFichier = array();
		private $_listeDossier = array();
		private $_list = '';
		
		private $_nb = 0;
		
		public function __construct($host = null, $port = null, $login = null, $password = null){
			$this->_host = ($host != null) ? $host : '';
			$this->_port = ($port != null) ? $port : '';
			$this->_login = ($login != null) ? $login : '';
			$this->_password = ($password != null) ? $password : '';
		}
		
		/**
		 * Liste des fichiers d'un dossier
		 * @param string $directory
		 * @return array
		 */
		/*public function nlist($directory = null){
			$connexion = ftp_connect($this->_host, $this->_port);
			if(ftp_login($connexion, $this->_login, $this->_password)){
				return ftp_nlist($connexion, $directory);
			}
			ftp_close($connexion);
		}*/
		
		/**
		 * Liste détaillé des fichier d'un dossier
		 * @return array
		 */
		public function rawlist(){
			$connexion = ftp_connect($this->_host, $this->_port);
			ftp_pasv($connexion, false);
			if(ftp_login($connexion, $this->_login, $this->_password)){
				return ftp_rawlist($connexion, '', true);
			}
			ftp_close($connexion);
		}
		
		public function isDir($file){
			
			return (ftp_size($this->_connexion, $file) == '-1') ? true : false;
		}
		
		public function nlist($directory = null){
			
			$array = ftp_nlist($this->_connexion, $directory);
			
			foreach($array as $file){
				
				if(strpos($file, '/') === false){
					if($directory != null){
						$file = $directory.'/'.$file;
					}
				}
				
				$dir = explode('/', $file);
				if($dir[count($dir)-1] == '.' || $dir[count($dir)-1] == '..') continue;
				
				if($this->isDir($file)){
					array_push($this->_listeDossier, $file);
				}else{
					array_push($this->_listeFichier, $file);
				}
			}
			
			
		}
		
		public function nlistExplorer($directory = null, $data = null){
			$this->nlist($directory);
		
			sort($this->_listeDossier);
			
			$indice = 0;
			$max = count($this->_listeDossier);
			foreach($this->_listeDossier as $dir){
				
				if(strpos($dir, '/') === false){
					if($directory != null){
						$dir = $directory.'/'.$dir;
					}
				}
				
			
				$indice++;
				
				$dataArbo = ($max == $indice) ? 0 : 1;
				$dataArbo = ($data != null) ? $data.'-'.$dataArbo : $dataArbo;
				
				$nameDir = explode('/', $dir);
				$arbo = '';
				$arbo2 = '';
				
				if(count($nameDir) > 1){
					$explode = explode('-', $data);
					$prochain = 0;
					for($i=1;$i<=count($nameDir)-1;$i++){
						if($i == 1){
							$margin = 7 + $prochain;
						}else{
							$margin = 30 + $prochain;
						}
						
						if($explode[$i-1] == '1'){
							$arbo2 .= '<img src="Images/Front/barre.png" style="margin-left:'.$margin.'px;" />';
							$prochain = 0;
						}else{
							if(($i-1) != 0){
								$prochain += 33;
							}else{
								$prochain += 10;
							}
						}
					}
					
					if($explode[count($explode)-1] == '1'){
						$arbo = 'margin-left:23px;';
					}else{
						$marg = 23;
						for($j=count($explode)-1;$j>=0;$j--){
							if($explode[$j] == '0'){
								if($j != 0){
									$marg += 33;
								}else{
									$marg += 10;
								}
							}else{
								break;
							}
						}
						$arbo = 'margin-left:'.$marg.'px;';
					}
				}
				
				$this->_list .= '<tr class="exist" data-dossier="'.urlencode($dir).'" data-arbo="'.$dataArbo.'">
									<td style="height:25px;padding:0;">
											'.$arbo2.'<img class="ico-ouverture" style="'.$arbo.'cursor:pointer;" onclick="explorerDir(\''.urlencode($dir).'\')" src="Images/Front/ico_plus.png" />
											<img src="Images/Front/folder.png" style="margin-right:5px;margin-top:4px;" /><span style="position:relative;top:3px;">'.$nameDir[count($nameDir)-1].'</span>
									</td>
								</tr>';
			}
		}
		
		public function nlistFiles($directory = null){
			$this->nlist($directory);
				
			sort($this->_listeFichier);
			sort($this->_listeDossier);
			
			$this->_list .= '<div style="float:left;width:0px;" data-dossier="'.urlencode($directory).'">';
			$this->_list .= '<table style="width:100%;">';
			foreach($this->_listeDossier as $dir){
				$nameDir = explode('/', $dir);
				$this->_list .= '<tr><td style="border-bottom:1px #000 solid;padding:10px;">'.$nameDir[count($nameDir)-1].'</td></tr>';
			}
				
			foreach($this->_listeFichier as $file){
				$nameFile = explode('/', $file);
				$this->_list .= '<tr><td style="border-bottom:1px #000 solid;padding:10px;">'.$nameFile[count($nameFile)-1].'</td></tr>';
			}
			$this->_list .= '</table>';
			$this->_list .= '</div>';
		}
		
		public function connect(){
			$connexion = ftp_connect($this->_host, $this->_port);//$connexion = ;
			ftp_pasv($connexion, false);
			if(ftp_login($connexion, $this->_login, $this->_password)){
				$this->_connexion = $connexion;
			}
		}
		
		public function close(){
			ftp_close($this->_connexion);
		}
		
		public function getlist(){
			return $this->_list;
		}
		
		
		public function setHost($host){
			$this->_host = $host;
		}
		
		public function setPort($port){
			$this->_port = $port;
		}
		
		public function setLogin($login){
			$this->_login = $login;
		}
		
		public function setPassword($password){
			$this->_password = $password;
		}
		
	}