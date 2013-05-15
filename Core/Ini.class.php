<?php
	
	/**
	 * Gère un fichier .ini
	 * @author Valentin
	 *
	 */
	class Core_Ini{
		
		private $_file;
		private $_section;
		public $_ini_array;
		
		public function __construct($file, $section = null){
			$this->_file = $file;
			$this->_section = $section;
			$this->load($section);
			$this->getLegacySection();
		}
		
		/**
		 * Charge le fichier
		 */
		private function load($section){
			$tab = parse_ini_file($this->_file, true);
			$tabSection = array();
			
			foreach($tab as $key => $value){
				if($section != ''){
					if(strpos($key, $section) !== false){
						$position = strpos($key, ':');
						
						if($position === false){
							$tabSection[$key] = $tab[$key];
						}else{
							$sectionLeg = trim(strstr($key, ':', true));
							$sectionPar = trim(substr($key, $position+1));
							
							if($sectionLeg == $section){
								if(array_key_exists($sectionLeg, $tabSection)){
	
									if(array_key_exists($sectionPar, $tabSection)){
										$merge = array_merge($tabSection[$sectionLeg], $tabSection[$sectionPar], $tab[$key]);
									}else{
										$merge = array_merge($tabSection[$sectionLeg], $tab[$sectionPar], $tab[$key]);
									}
									
									$tabSection[$sectionLeg] = $merge;
								}else{
									if(array_key_exists($sectionPar, $tabSection)){
										$merge = array_merge($tabSection[$sectionPar], $tab[$key]);
									}else{
										$merge = array_merge($tab[$sectionPar], $tab[$key]);
									}
									
									$tabSection[$sectionLeg] = $merge;
								}
							}
						}
					}
				}else{
					$position = strpos($key, ':');
					if($position === false){	//Si il n'y a pas d'héritage
						$tabSection[$key] = $tab[$key];
					}else{	//Si il y a héritage
						$sectionLeg = trim(strstr($key, ':', true));
						$sectionPar = trim(substr($key, $position+1));
							
						if(array_key_exists($sectionLeg, $tabSection)){
							$tabSection[$sectionLeg] = array_merge($tabSection[$sectionLeg], $tabSection[$sectionPar], $tab[$key]);
						}else{
							$tabSection[$sectionLeg] = array_merge($tabSection[$sectionPar], $tab[$key]);
						}
					}
				}
			}
			
			$this->_ini_array = $tabSection;
		}
		
		/**
		 * Récupère les paramètres des sections
		 */
		private function getLegacySection(){
		    $output_array = array();

		    //Parcours le tableau du fichier charger
		    foreach ($this->_ini_array as $key => $val) {
		    		
		        //Explode les clés possédant un point
		    	foreach($val as $key1=>$val1){					
			        
			        $temp1 = explode('.',$key1);
			        if (!is_array($temp1)) {
			            continue;
			        }
			        
			        //Met le pointeur à la fin du tableau
			        krsort($temp1);	
			        					
			        //Commence temporairement avec un tableau possédant la valeur final		
		        	$temp2 = $val1;	
		        							
			        //Parcours le tableau possédant les clés
			        foreach($temp1 as $val2) {					
			            if ($val2 === false) {
			                continue;
			            }

			            $temp2 = array($val2 => $temp2);
			        }
			        
			        if(array_key_exists($key, $output_array)){
			        	$output_array[$key] = array_merge_recursive($output_array[$key],$temp2);
			        }else{
			        	$output_array[$key] = $temp2;
			        }
		    	}
		    }

		    foreach($output_array as $key => $value){
		    	foreach($value as $keySs => $valueSs){
		    		$this->{$keySs} = $this->arrayToObject($valueSs);
		    	}
		    }
		    
		    $this->_ini_array = $output_array;
		}
		
		/**
		 * Convertis un tableau en objet
		 * @param array $data
		 * @return object
		 */
		private function arrayToObject($data) {
			return is_array($data) ? (object) array_map(__METHOD__, $data) : $data;
		}
		
		/**
		 * Retourne le résultat du chargement du fichier .ini
		 */
		public function toArray(){
			return $this->_ini_array;
		}
		
	}