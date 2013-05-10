<?php 

class Models_HelperMenu
{
		
	static public function createMenuGauche()
	{
		$html = '';
		
		if(isset($_SESSION['AUTH']) && $_SESSION['ROLE'] == 1)
		{
			$html = '
				<nav id="menu" >
					<ul>
						<li>Dashboard</li>
					</ul>
				</nav>
			';
		}
		
		return $html;
	}
	
	static public function createSidebar()
	{
		$html = '';
		
		if(isset($_SESSION['AUTH']) && $_SESSION['ROLE'] == 1)
		{
			$html = '
				<header>
					<ul class="menu_right" >
						<li id="user" ><a href="#" class="toggle-data" >Profil</a>
							<ul>
								<li>
									<a class="mn_logout" href="logout.html" ><span>Deconnexion</span></a>
								</li>
							</ul>
						</li>
					</ul>
				</header>
			';
		}
		
		return $html;
		
	}
}