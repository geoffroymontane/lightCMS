<?php
	session_start();
	sleep(1);
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	

	if(isset($_GET['step1'])){
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
			
						$query=$pdo->prepare("CREATE TABLE IF NOT EXISTS lightcms_contents (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,name VARCHAR(100),date INT,html TEXT,markdown TEXT);");
						$query->execute();

						$query=$pdo->prepare("CREATE TABLE IF NOT EXISTS lightcms_images (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,name VARCHAR(255),date INT,extension VARCHAR(10));");
						$query->execute();
				
						$query=$pdo->prepare("SELECT * FROM lightcms_users");
						$query->execute();
						$countUsers=$query->rowCount();

						if($countUsers==0){
							$_SESSION["signUpAuthorization"]=true;
							include("step2.php");
						}
						else{
							$msg="La connexion avec la base de données est opérationnelle. Un compte administrateur a été détecté. Vous pouvez vous connecter avec celui-ci.";
							include("msg.php");
						}
					}
					else{
						$msg="Impossible de créer le fichier de configuration : permission refusée.";
						include("msg.php");
					}

				}
				catch(Exception $e){
					$msg="Impossible de se connecter à la base de données : les informations fournies sont incorrectes.";	
					include("step1.php");
				}

			}
		}
	}
	else if(isset($_GET['step2'])){
		if(isset($_SESSION["signUpAuthorization"]) && $_SESSION["signUpAuthorization"]){
			if(isset($_POST['password']) && isset($_POST['password_bis']) && isset($_POST['login']) && strcmp($_POST["password"],$_POST["password_bis"])==0){
				include("../credentials.php");
				if(file_exists("../credentials.php")){
					$DBconnect = "mysql:dbname=".$DBName.";host=".$DBhost;
					$pdo = new PDO($DBconnect, $DBowner, $DBpw);

					$hash=password_hash($_POST['password'],PASSWORD_DEFAULT);
					$query=$pdo->prepare("INSERT INTO lightcms_users (email,password) VALUES (?,?)");
					$query->execute(array($_POST["login"],$hash));

					$_SESSION["signUpAuthorization"]=false;
					$msg="Compte créé avec succès.";	
					include("msg.php");
				}
			}
			else{
				$msg="Veuillez vérifier votre saisie.";
				include("step2.php");
			}
		}
		else{
			$msg="Vous n'êtes pas autorisé à créer un compte administrateur.";
			include("step2.php");
		}
	}
	else{
		if(file_exists("../credentials.php")){
			$msg="Il est nécessaire de supprimer le fichier credentials.php afin de pouvoir relancer le processus d'installation.";
			include("msg.php");
		}
		else{
			include("step1.php");
		}
	}
?>


