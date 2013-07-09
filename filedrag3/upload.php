<?php
/*	$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

	if ($fn) {
		// AJAX call
		/*file_put_contents('uploads/' . $fn, file_get_contents('php://input'));
		echo "$fn uploaded";*/
		
	/*	$file = file_get_contents('php://input');
		//$remote_file = $files['name'];
		
		// Mise en place d'une connexion basique
		$conn_id = ftp_connect('valentin-thulliez.com');
		
		// Identification avec un nom d'utilisateur et un mot de passe
		$login_result = ftp_login($conn_id, 'u67776459', 'lorcomlier80');
		var_dump($fn);
		// Charge un fichier
		if (ftp_put($conn_id, '/'.$fn, $file, FTP_BINARY)) {
			echo "Le fichier $file a té chargé avec succès\n";
		} else {
			echo "Il y a eu un problème lors du chargement du fichier $file\n";
			}
		
			// Fermeture de la connexion
			ftp_close($conn_id);
		
		exit();
	}
	else{*/
		// form submit
		$files = $_FILES['fileselect'];

				/*$fn = $files['name'][$id];
				move_uploaded_file($files['tmp_name'][$id], 'uploads/' . $fn);
				echo "<p>File $fn uploaded.</p>";*/
				
		$file = $files['tmp_name'][0];
		$remote_file = $files['name'][0];
		
		// Mise en place d'une connexion basique
		$conn_id = ftp_connect('valentin-thulliez.com');
		
		// Identification avec un nom d'utilisateur et un mot de passe
		$login_result = ftp_login($conn_id, 'u67776459', 'lorcomlier80');
		
		// Charge un fichier
		if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) {
			echo "Le fichier ".$file." a té chargé avec succès\n";
		} else {
		echo "Il y a eu un problème lors du chargement du fichier $file\n";
		}
		
		// Fermeture de la connexion
		ftp_close($conn_id);
				

		
		
		
	//}
	/*$files = $_FILES['fileselect'];

	ob_end_flush();
	$remote_file = 'debian';
	$local_file = 'debian-7.1.0-i386-netinst.iso';
	
	$ftp_server = 'valentin-thulliez.com';
	$ftp_user_name = 'u67776459';
	$ftp_user_pass = 'lorcomlier80';
	
	$fp = fopen($local_file, 'r');
	$conn_id = ftp_connect($ftp_server);
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	$ret = ftp_nb_fput($conn_id, $remote_file, $fp, FTP_BINARY);
	while ($ret == FTP_MOREDATA) {
		// Establish a new connection to FTP server
		if(!isset($conn_id2)) {
			$conn_id2 = ftp_connect($ftp_server);
			$login_result2 = ftp_login($conn_id2, $ftp_user_name, $ftp_user_pass);
		}
	
		// Retreive size of uploaded file.
		if(isset($conn_id2)) {
			clearstatcache(); // <- this must be included!!
			$remote_file_size = ftp_size($conn_id2, $remote_file);
		}
	
		// Calculate upload progress
		$local_file_size  = filesize($local_file);
		if (isset($remote_file_size) && $remote_file_size > 0 ){
			$i = ($remote_file_size/$local_file_size)*100;
			printf("%d%% uploaded<br>", $i);
			flush();
		}
		$ret = ftp_nb_continue($conn_id);
	}
	
	if ($ret != FTP_FINISHED) {
		print("There was an error uploading the file...<br>");
		exit(1);
	}
	else {
		print("Done.<br>");
	}
	fclose($fp);
	?>*/

