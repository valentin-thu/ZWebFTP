<?php 

	$remote_file = $_POST['name'];
	
	// Mise en place d'une connexion basique
	$conn_id = ftp_connect('valentin-thulliez.com');
	
	// Identification avec un nom d'utilisateur et un mot de passe
	$login_result = ftp_login($conn_id, 'u67776459', 'lorcomlier80');
	
	// Charge un fichier
	echo ftp_size($conn_id, $remote_file);
	
	// Fermeture de la connexion
	ftp_close($conn_id);