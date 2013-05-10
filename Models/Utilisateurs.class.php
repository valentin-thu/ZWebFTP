<?php 

class Models_Utilisateurs extends Core_DataBase
{
	public function identification($login, $mdp)
	{
		$query = 'SELECT * 
					FROM utilisateurs , type_utilisateurs 
					WHERE type_utilisateurs_id = utilisateurs_type
					AND utilisateurs_login = :login
					AND utilisateurs_mdp = :mdp';
		$sql = $this->bdd->prepare($query);
		$sql->execute(array(':login' => $login, ':mdp' => $mdp));
		
		$objet = $sql->fetchAll(PDO::FETCH_CLASS, 'DbTables_Utilisateurs');
		
		if(count($objet) > 0)
		{
			$_SESSION['AUTH'] = true;
			$_SESSION['ROLE'] = $objet[0]->idType();
		}
		else 
		{
			$_SESSION['AUTH'] = false;
		}
		
		return $_SESSION['AUTH'];
	}
}