<?php

	/**
	 * Modifie le doctype de l'application
	 * @author Valentin
	 *
	 */
	class Core_Layout_HeadDoctype{
		
		protected $_headDoctype = '';
		protected $_arrayDoctype = array(
                    'XHTML11'             => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
                    'XHTML1_STRICT'       => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
                    'XHTML1_TRANSITIONAL' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
                    'XHTML1_FRAMESET'     => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">',
                    'XHTML1_RDFA'         => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">',
                    'XHTML_BASIC1'        => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">',
                    'XHTML5'              => '<!DOCTYPE html>',
                    'HTML4_STRICT'        => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">',
                    'HTML4_LOOSE'         => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
                    'HTML4_FRAMESET'      => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">',
                    'HTML5'               => '<!DOCTYPE html>'
                );
		
		/**
		 * Retourne le doctype
		 */
		public function getDoctype(){
			return $this->_headDoctype;
		}
		
		/**
		 * Vérifie si un doctype est présent
		 * @return boolean
		 */
		public function hasDoctype(){
			return ($this->_headDoctype != '') ? true : false;
		}
		
		/**
		 * Modifie le doctype selon la constante passé en paramètre
		 * @param string $doctype
		 */
		public function setDoctype($doctype){
			$objetDoctype = Core_Registry::get('headDoctype', 'HEAD');
		
			if(is_object($objetDoctype)){
				$objetDoctype->setVarDoctype($doctype);
				Core_Registry::set('headDoctype', $objetDoctype, 'HEAD');
			}else{
		
				$objetDoctype = new Core_Layout_HeadDoctype();
				$objetDoctype->setVarDoctype($doctype);
				Core_Registry::set('headDoctype', $objetDoctype, 'HEAD');
			}
		
			return $objetDoctype;
		}
		
		/**
		 * Modifie la variable $_doctype de l'objet
		 * @param string $doctype
		 */
		private function setVarDoctype($doctype){
			$this->_headDoctype = $this->_arrayDoctype[$doctype];
		}
		
		/**
		 * Ecrit le doctype a l'appel de l'objet en écriture
		 * @return string
		 */
		public function __toString(){
			return $this->getDoctype();
		}
		
	}