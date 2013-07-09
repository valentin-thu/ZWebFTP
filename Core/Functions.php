<?php
	
	/**
	 * Retourne un message d'erreur selon $key
	 * @param string $key
	 */
	function _e($key, $var = null){
		$resources = Core_Registry::get('Translate', 'RESOURCES');
		return $resources->getError($key, $var);
	}
	
	function _unity($size){
		
		if($size < 1){
			return $size.' octet';
		}else{
			if($size < 1024){
				return $size.' octets';
			}else{
				if($size < (1024*1024)){
					return number_format(($size/1024), 2).'Ko';
				}else{
					if($size < (1024*1024*1024)){
						return number_format(($size/(1024*1024)), 2).'Mo';
					}else{
						if($size < (1024*1024*1024*1024)){
							return number_format(($size/(1024*1024*1024)), 2).'Go';
						}else{
							if($size < (1024*1024*1024*1024*1024)){
								return number_format(($size/(1024*1024*1024*1024)), 2).'To';
							}
						}
					}
				}
			}
		}
		
	}