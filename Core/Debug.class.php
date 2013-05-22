<?php
	
	/**
	 * Class permettant de débuggué
	 * @author Valentin
	 *
	 */
	class Core_Debug{
		
		/**
		 * Retourne un var_dump()
		 * @param unknown $var
		 */
		static public function dump($var){
			return var_dump($var);
		}
		
		/**
		 * Retourne un print_r()
		 * @param unknown $var
		 */
		static public function print_r($var){
			echo '<pre>';
			echo print_r($var);
			echo '</pre>';
		}
		
		/**
		 * Retourne un print_r() en JavaScript
		 * @param unknown $var
		 */
		static public function print_rJS($var){
			echo '<pre>';
				$out = print_r($var, true);
				$out = preg_replace('/([ \t]*)(\[[^\]]+\][ \t]*\=\>[ \t]*[a-z0-9 \t_]+)\n[ \t]*\(/iUe',"'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $out);
				$out = preg_replace('/^\s*\)\s*$/m', '</div>', $out);
			
				echo '<script language="Javascript">function toggleDisplay(id) { document.getElementById(id).style.display = (document.getElementById(id).style.display == "block") ? "none" : "block"; }</script>'."\n$out";
			echo '</pre>';
		}
		
	}