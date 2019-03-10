<?php
	session_start();
	sleep(1);

	include('database.php');

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
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="global.css" rel="stylesheet" type="text/css">
		<link href="ui.css" rel="stylesheet" type="text/css">
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
			<div id="connectionFormTitle">Connexion</div>
			<form action='connection.php' method='post' id='connectionForm'>
				<label for="email" class='connectionFormInput' class="textInputLabel">
					<input id="email" name="email" placeholder="&nbsp;" class="textInput"/>
					<label for="email" class="textInputLabel">Email</label>
				</label>
				<label for="password" class='connectionFormInput' class="textInputLabel">
					<input id="password" type="password" name="password" placeholder="&nbsp;" class="textInput"/>
					<label for="password" class="textInputLabel">Mot de passe</label>
				</label>

				<div class='button_container' style="text-align:center">
					<div id='submit' class='button_red' onclick="submit();">
						<i class="fas fa-sign-in-alt"></i>
						&nbsp;Connexion
					</div>
				</div>

			</form>
			
			<?php
			if(strcmp($msg,"")!=0){
				echo "
				<div id='connectionMsg'>
					".$msg."
				</div>";
			}
			?>
		</div>
	</body>


</html>
