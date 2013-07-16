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
		
		private $_arrayRecap = array();
		
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
		public function rawlist($directory = null){
			ftp_chdir($this->_connexion, $directory);
			if (is_array($children = @ftp_rawlist($this->_connexion, '.'))) {
				$items = array();
				
				foreach ($children as $child) {
					$chunks = preg_split("/\s+/", $child);
					list($item['droits'], $item['index'], $item['user'], $item['group'], $item['size'], $item['mois'], $item['jour'], $item['heure']) = $chunks;
					$item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file';
					array_splice($chunks, 0, 8);
					$items[implode(" ", $chunks)] = $item;
				}
			
				return $items;
			}else{
				return null;
			}
		}
		
		public function rawlistFiles($directory = null){
			$items = $this->rawlist($directory);
			
			foreach($items as $item=>$value){
				if($value['type'] == 'directory'){
					$this->_listeDossier[$item] = $items[$item];
				}else{
					$this->_listeFichier[$item] = $items[$item];
				}
			}
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
			$this->nlist(html_entity_decode($directory));
			
			sort($this->_listeDossier);
			
			if($directory == null) {
				$this->_arrayRecap['/'] = $this->_listeDossier;
			}else{
				$this->_arrayRecap[$directory] = $this->_listeDossier;
			}
			
			Core_Sessions::set('ftp', $this, 'FTP');
			
			$indice = 0;
			$max = count($this->_listeDossier);
			
			$this->_list .= '<ul style="-webkit-padding-start:0px;list-style:none;">';
			
			foreach($this->_listeDossier as $dir){
				
				if(strpos($dir, '/') === false){
					if($directory != null){
						$dir = $directory.'/'.$dir;
					}
				}
				
				if($this->hasDir($dir)){
					$srcImg = 'ico_plus';
					$onclick = 'onclick="explorerDir(\''.urlencode($dir).'\')"';
					$cursor = 'cursor:pointer;';
				}else{
					$srcImg = 'ico_nodir';
					$onclick = '';
					$cursor = '';
				}
				
				
				$indice++;
				
				if($max == $indice){
					$dataArbo = 0;
					if($srcImg == 'ico_nodir'){
						$srcImg = 'ico_nodir_fin';
					}
				}else{
					$dataArbo = 1;
				}
				
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
				
				$this->_list .= '<li class="exist" data-dossier="'.urlencode($dir).'" data-arbo="'.$dataArbo.'">	
									'.$arbo2.'<img class="ico-ouverture" data-dossier="'.urlencode($dir).'" style="'.$arbo.$cursor.'" '.$onclick.' src="Images/Front/'.$srcImg.'.png" />
									<img src="Images/Front/folder.png" style="margin-right:5px;margin-top:4px;" /><span onclick="getFiles(\''.urlencode($dir).'\')" style="cursor:pointer;position:relative;top:3px;" data-dossier="'.urlencode($dir).'">'.$nameDir[count($nameDir)-1].'</span>
								</li>';
			}
			
			$this->_list .= '</ul>';
		}
		
		public function nlistFiles($directory = null, $start = false){
			$this->rawlistFiles($directory);
			
			
			
			ksort($this->_listeDossier);
			ksort($this->_listeFichier);
			
			$width = ($start == false) ? '0px' : '100%';

			$this->_list .= '<div style="float:left;width:'.$width.';" data-dossier="'.urlencode($directory).'">';
			$this->_list .= '<table style="width:100%;">';
			
			$this->_list .= '<tr style="border-bottom:2px #000 solid;">
								<th>Nom du fichier</th>
								<th style="width:10%">Poids</th>
								<th style="width:13%">Type de fichier</th>
								<th style="width:13%">Les permissions</th>
								<th style="width:17%">Dernière modification</th>
								<th style="width:15%">Propriétaire/Groupe</th>
							</tr>';
			
			foreach($this->_listeDossier as $dir => $value){
				
				if(strpos($dir, '/') === false){
					if($directory != null){
						$dir = $directory.'/'.$dir;
					}
				}
				
				$nameDir = explode('/', $dir);
				
				$annee = (strpos($value['heure'], ':') === false) ? ' '.$value['heure'] : '';
				$heure = (strpos($value['heure'], ':') !== false) ? ' '.date('Y').' à '.$value['heure'] : '';
				
				$jour = ($value['jour'] < 10) ? '0'.$value['jour'] : $value['jour'];
				
				switch($value['mois']){
					case 'Jan' : $mois = 'Janvier';break;
					case 'Feb' : $mois = 'Février';break;
					case 'Mar' : $mois = 'Mars';break;
					case 'Apr' : $mois = 'Avril';break;
					case 'May' : $mois = 'Mai';break;
					case 'Jun' : $mois = 'Juin';break;
					case 'Jul' : $mois = 'Juillet';break;
					case 'Aug' : $mois = 'Août';break;
					case 'Sep' : $mois = 'Septembre';break;
					case 'Oct' : $mois = 'Octobre';break;
					case 'Nov' : $mois = 'Novembre';break;
					case 'Dec' : $mois = 'Décembre';break;
				}
				
				$droits = $value['droits'];
				$chmod = '';
				$calcul = 0;
				$j = 0;
				for($i=1;$i<10;$i++){
					$j++;
						
					if($j == 4){
						$chmod .= $calcul;
						$calcul = 0;
						$j = 1;
					}
						
					if($droits[$i] == 'r'){
						$calcul += 4;
					}else{
						if($droits[$i] == 'w'){
							$calcul += 2;
						}else{
							if($droits[$i] == 'x'){
								$calcul += 1;
							}
						}
					}
						
					if($i == 9){
						$chmod .= $calcul;
					}
					
				}
				
				
				if($nameDir[count($nameDir)-1] == '.' || $nameDir[count($nameDir)-1] == '..') continue;
				$this->_list .= '<tr style="border-bottom:1px #000 solid;">
									<td style="padding:10px;"><img style="margin-right:10px;" src="/Images/Front/folder.png" alt=""/><span style="cursor:pointer;-webkit-user-select:none;" ondblclick="getFiles(\''.urlencode($dir).'\')">'.$nameDir[count($nameDir)-1].'</span></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;">Répertoire</td>
									<td style="text-align:center;">'.$value['droits'].' ('.$chmod.')</td>
									<td style="text-align:center;">'.$jour.' '.$mois.$annee.$heure.'</td>
									<td style="text-align:center;">'.$value['user'].' / '.$value['group'].'</td>
								</tr>';
			}
				
			foreach($this->_listeFichier as $file => $value){
				$nameFile = explode('/', $file);
				
				$annee = (strpos($value['heure'], ':') === false) ? ' '.$value['heure'] : '';
				$heure = (strpos($value['heure'], ':') !== false) ? ' '.date('Y').' à '.$value['heure'] : '';
				
				$jour = ($value['jour'] < 10) ? '0'.$value['jour'] : $value['jour'];
				
				$droits = $value['droits'];
				
				$chmod = '';
				$calcul = 0;
				$j = 0;
				for($i=1;$i<10;$i++){
					$j++;
						
					if($j == 4){
						$chmod .= $calcul;
						$calcul = 0;
						$j = 1;
					}
						
					if($droits[$i] == 'r'){
						$calcul += 4;
					}else{
						if($droits[$i] == 'w'){
							$calcul += 2;
						}else{
							if($droits[$i] == 'x'){
								$calcul += 1;
							}
						}
					}
						
					if($i == 9){
						$chmod .= $calcul;
					}
					
				}
				
				switch($value['mois']){
					case 'Jan' : $mois = 'Janvier';break;
					case 'Feb' : $mois = 'Février';break;
					case 'Mar' : $mois = 'Mars';break;
					case 'Apr' : $mois = 'Avril';break;
					case 'May' : $mois = 'Mai';break;
					case 'Jun' : $mois = 'Juin';break;
					case 'Jul' : $mois = 'Juillet';break;
					case 'Aug' : $mois = 'Août';break;
					case 'Sep' : $mois = 'Septembre';break;
					case 'Oct' : $mois = 'Octobre';break;
					case 'Nov' : $mois = 'Novembre';break;
					case 'Dec' : $mois = 'Décembre';break;
				}
				
				$this->_list .= '<tr style="border-bottom:1px #000 solid;">
									<td style="padding:10px;"><img style="margin-right:10px;" src="/Images/Front/file.png" alt=""/>'.$nameFile[count($nameFile)-1].'</td>
									<td style="text-align:center;">'._unity($value['size']).'</td>
									<td style="text-align:center;">Fichier</td>
									<td style="text-align:center;">'.$value['droits'].' ('.$chmod.')</td>
									<td style="text-align:center;">'.$jour.' '.$mois.$annee.$heure.'</td>
									<td style="text-align:center;">'.$value['user'].' / '.$value['group'].'</td>
								</tr>';
			}
			$this->_list .= '</table>';
			$this->_list .= '</div>';
		}
		
		public function hasDir($directory){
			$array = ftp_nlist($this->_connexion, $directory);
			$return = false;
			
			
			
			foreach($array as $file){
				
				if(strpos($file, '/') === false){
					if($directory != null){
						$file = $directory.'/'.$file;
					}
				}
			
				$dir = explode('/', $file);
				if($dir[count($dir)-1] == '.' || $dir[count($dir)-1] == '..') continue;
			
				if($this->isDir($file)){
					$return = true;
				}
			}
			
			return $return;
		}
		
		public function connect(){
			$this->_list = '';
			$this->_listeDossier = array();
			$this->_listeFichier = array();
			$this->_nb = 0;
			
				
			
			$connexion = ftp_connect($this->_host, $this->_port);//$connexion = ;
			ftp_pasv($connexion, false);
			if(ftp_login($connexion, $this->_login, $this->_password)){
				$this->_connexion = $connexion;
				
			}
		}
		
		public function getRecap(){
			return $this->_arrayRecap;
		}
		
		public function resetRecap(){
			$this->_arrayRecap = array();
		}
		
		public function close(){
			ftp_close($this->_connexion);
		}
		
		public function getlist(){
			return $this->_list;
		}
		
		
		public function getHost(){
			return $this->_host;
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