<?php
	session_start();
	sleep(1);
	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);


	//
	// Read mastercode and re-generates it if it is outdated
	//
	if(file_exists("../mastercode.php")){
		include("../mastercode.php");

		//If the mastercode is outdated
		if($time<time()){
			$mastercode=bin2hex(random_bytes(15));	
			
			//Expiration duration of generated mastercode in seconds
			$duration=30*60;
	
			$time=time()+$duration;

			$file=fopen("../mastercode.php","w");
			fwrite($file,"<?php\n");
			fwrite($file,"//WARNING : this file must be kept secret\n\$mastercode=\n//Mastercode below \n'".$mastercode."'\n//This mastercode is regenerated every 30 minutes\n;\n\n");
			fwrite($file,"\$time=".$time.";\n");
			fwrite($file,"?>");
			fclose($file);
	
			if(!file_exists("../mastercode.php")){
				$msg="Impossible de créer le fichier de configuration : permission refusée.";
				include("mastercode.php");
			}
		}
	}
	// If the mastercode does not exist
	else{
		$mastercode=bin2hex(random_bytes(15));	
			
		//Expiration duration of generated mastercode in seconds
		$duration=30*60;

		$time=time()+$duration;

		$file=fopen("../mastercode.php","w");
		fwrite($file,"<?php\n");
		fwrite($file,"//WARNING : this file must be kept secret\n\$mastercode=\n//Mastercode below \n'".$mastercode."'\n//This mastercode is regenerated every 30 minutes\n;\n\n");
		fwrite($file,"\$time=".$time.";\n");
		fwrite($file,"?>");
		fclose($file);

		if(!file_exists("../mastercode.php")){
			$msg="Impossible de créer le fichier de configuration : permission refusée.";
			include("mastercode.php");
		}
	}
	
	// Mastercode authentification
	if(isset($_POST['mastercode'])){
		// If the mastercode is correct
		if(strcmp($_POST['mastercode'],$mastercode)==0){
			$_SESSION['masterAuthorizationGranted']=$_POST['mastercode'];
			//If the database is already configured
			if(file_exists("../credentials.php")){
				include("menu.php");
			}
			else{
				include("database.php");
			}
		}
		else{
			$msg="Le code maître est incorrect.";
			include("mastercode.php");
		}
	}
	// When authentified
	else if(isset($_SESSION['masterAuthorizationGranted']) && strcmp($_SESSION['masterAuthorizationGranted'],$mastercode)==0){
		// Database setup ui
		if(isset($_GET['database'])){
			if(file_exists("../credentials.php")){
				$msg="Il faut supprimer credentials.php afin de pouvoir relancer le processus d'installation.";
				include("msg.php");
			}
			else{
				if(isset($_POST['host']) && isset($_POST['name']) && isset($_POST['user']) && isset($_POST['password'])){
					try{
						$DBconnect = "mysql:dbname=".$_POST['name'].";host=".$_POST['host'];
						$pdo = new PDO($DBconnect,$_POST['user'],$_POST['password']);

						$file=fopen("../credentials.php","w");
						fwrite($file,"<?php ");
						fwrite($file,"\$DBhost='".addslashes($_POST["host"])."';");
						fwrite($file,"\$DBowner='".addslashes($_POST["user"])."';");
						fwrite($file,"\$DBpw='".addslashes($_POST["password"])."';");
						fwrite($file,"\$DBName='".addslashes($_POST["name"])."';");
						fwrite($file," ?>");
						fclose($file);

						if(file_exists("../credentials.php")){

							$query=$pdo->prepare("CREATE TABLE IF NOT EXISTS lightcms_users (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,email VARCHAR(255),password VARCHAR(255));");
							$query->execute();
				
							$query=$pdo->prepare("CREATE TABLE IF NOT EXISTS lightcms_contents (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,name VARCHAR(100),date INT,html TEXT);");
							$query->execute();

							$query=$pdo->prepare("CREATE TABLE IF NOT EXISTS lightcms_images (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,name VARCHAR(255),date INT,extension VARCHAR(10));");
							$query->execute();
					
							$query=$pdo->prepare("SELECT * FROM lightcms_users");
							$query->execute();
							$countUsers=$query->rowCount();
							
							$msg="La base de données est connectée. Il y a pour l'heure ".$countUsers." compte(s) administrateur(s). Voulez-vous créer un compte ?";
							include("ask.php");

						}
						else{
							$msg="Impossible de créer le fichier de configuration : permission refusée.";
							include("database.php");
						}

					}
					catch(Exception $e){
						$msg="Impossible de se connecter à la base de données : les informations fournies sont incorrectes.";	
						include("database.php");
					}

				}
				else{
					include("database.php");
				}
			}
		}
		// Sign-up ui
		else if(isset($_GET['signup'])){
			if(isset($_POST['password']) && isset($_POST['password_bis']) && isset($_POST['login']) && strcmp($_POST["password"],$_POST["password_bis"])==0){
				include("../credentials.php");
				if(file_exists("../credentials.php")){
					if(strlen($_POST['password'])>=8){
						if(filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)){
							$DBconnect = "mysql:dbname=".$DBName.";host=".$DBhost;
							$pdo = new PDO($DBconnect, $DBowner, $DBpw);

							$hash=password_hash($_POST['password'],PASSWORD_DEFAULT);
							$query=$pdo->prepare("INSERT INTO lightcms_users (email,password) VALUES (?,?)");
							$query->execute(array($_POST["login"],$hash));

							$msg="Compte créé avec succès";	
							include("msg.php");
						}
						else{
							$mail=$_POST['login'];
							$msg="Ce n'est pas une adresse email valide.";
							include("signup.php");
						}
					}
					else{
						$mail=$_POST['login'];
						$msg="Le mot de passe doit faire au moins 8 caractères.";
						include("signup.php");
					}
				}
				else{
					$mail=$_POST['login'];
					$msg="La base de données n'est pas configurée.";
					include("signup.php");
				}
			}
			else{
				$mail=$_POST['login'];
				$msg="Veuillez vérifier votre saisie.";
				include("signup.php");
			}
		} else{
			include("menu.php");
		}

	}
	else{
		include("mastercode.php");
	}
?>


