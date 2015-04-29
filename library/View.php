<?

/**
* 
*/
class View extends Response
{
	protected $templete;
	protected $vars = array();


	public function __construct($template,$vars = array())
	{
		$this->template = $template;
		$this->vars = $vars;
		

	}

	public function getTemplate()
	{
		return $this->template;
	}

	public function getVars()
	{
		return $this->vars;
	}

	public function execute()
	{
		$template = $this->getTemplate
		call_user_func(function(){

			extract($vars);	
			require "views/".$template.".php";	
		});

	}
}
