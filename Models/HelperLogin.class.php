<?php 

class Models_HelperLogin
{
	private $_content;
	
	public function __construct()
	{
		ob_start();			
        require_once '../Applications/Admin/Views/Index/login.phtml';
        $content = ob_get_clean();
        $this->_content = $content;
	}
	
	public function getContent()
	{
		return $this->_content;
	}
}