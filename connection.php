<?php

	include('database.php');
	session_start();
	sleep(1);

	if(isset($_GET["disconnect"])){
		$msg="Déconnecté avec succès";
		$_SESSION["isConnected"]=0;	
	}

	if(isset($_POST['email']) && isset($_POST['password'])){

		$query=$pdo->prepare("SELECT * FROM lightcms_users WHERE email=?");
		$query->execute(array($_POST['email']));
		$tab=$query->fetchAll();
		
		if(password_verify($_POST['password'],$tab[0]["password"])){
			$_SESSION["isConnected"]=1;	
			$_SESSION["email"]=$_POST["email"];	
			header("Location: index.php");
			exit();
		}
		else{
			$_SESSION["isConnected"]=0;	
			$msg="Erreur d'identification";
		}
	}
?>

<html>

	<head>
		
		<meta charset="UTF-8"/>
		<link href="fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="global.css" rel="stylesheet" type="text/css">
		<link href="connection.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script>
			function submit(){
				document.getElementById('connectionForm').submit();
			}	
			function keyup(event){
				if(event.keyCode==13){
					submit();
				}
			}
		</script>
	</head>

	<body id="connectionBody" onkeyup="keyup(event)">

		<div id="connectionContent">
			<form action='connection.php' method='post' id='connectionForm'>

				<div class='connectionFormInput'>
					<label>Email</label>
					<input type="email" name="email"/>
				</div>
				<div class='connectionFormInput'>
					<label>Mot de passe</label>
					<input type="password" name="password"/>
				</div>

				<div id='submit' class='button' onclick="submit();">
				Connexion
				</div>

			</form>
			
			<?php
			if(strcmp($msg,"")!=0){
				echo "
				<div id='connectionMsg'>
					<span id='connectionMsgText'>".$msg."</span>
				</div>";
			}
			?>
		</div>
	</body>


</html>
