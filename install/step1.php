<html>

	<head>
		
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="../fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="../ui.css" rel="stylesheet" type="text/css">
		<link href="../global.css" rel="stylesheet" type="text/css">
		<link href="install.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script>
			function submit(){
				document.getElementById('installationForm').submit();
			}	
			function keyup(event){
				if(event.keyCode==13){
					submit();
				}
			}
		</script>
	</head>

	<body id="installationBody" onkeyup="keyup(event)">

		<div id="installationContent">
			<div id="installationFormTitle">Installation : base de données</div>
			<form action='index.php?step1' method='post' id='installationForm'>
				<span id='fullMsg'>
					Notre service nécessite une base de données MySQL ou MariaDB. Veuillez saisir vos informations de connexion.
				</span>
				<label for="host" class='installationFormInput' class="textInputLabel">
					<input id="host" name="host" placeholder="&nbsp;" class="textInput"/>
					<label for="host" class="textInputLabel">Hôte</label>
				</label>
				<label for="name" class='installationFormInput' class="textInputLabel">
					<input id="name" name="name" placeholder="&nbsp;" class="textInput"/>
					<label for="name" class="textInputLabel">Base de données</label>
				</label>
				<label for="user" class='installationFormInput' class="textInputLabel">
					<input id="user" name="user" placeholder="&nbsp;" class="textInput"/>
					<label for="user" class="textInputLabel">Utilisateur</label>
				</label>
				<label for="password" class='installationFormInput' class="textInputLabel">
					<input id="password" type="password" name="password" placeholder="&nbsp;" class="textInput"/>
					<label for="password" class="textInputLabel">Mot de passe</label>
				</label>

				<div class='button_container' style="text-align:center">
					<div id='submit' class='button_red' onclick="submit();">
						Etape suivante&nbsp;
						<i class="fas fa-angle-right"></i>
					</div>
				</div>

			</form>
			
			<?php
			if(isset($msg) && strcmp($msg,"")!=0){
				echo "
				<div id='installationMsg'>
					<div id='installationMsg_'>
					".$msg."
					</div>
				</div>";
			}
			?>
		</div>
	</body>


</html>
