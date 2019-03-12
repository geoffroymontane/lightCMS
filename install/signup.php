<?php 
	if(isset($mail)){
		$value=htmlspecialchars($mail);	
	}
	else{
		$value="";
	}
?>
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
			<div id="installationFormTitle">Installation : inscription</div>
			<form action='index.php?signup' method='post' id='installationForm'>
				<label for="login" class='installationFormInput' class="textInputLabel">
					<input id="login" name="login" placeholder="&nbsp;" class="textInput" value="<?php echo $value;?>"/>
					<label for="login" class="textInputLabel">Email</label>
				</label>
				<label for="password" class='installationFormInput' class="textInputLabel">
					<input id="password" type="password" name="password" placeholder="&nbsp;" class="textInput"/>
					<label for="password" class="textInputLabel">Mot de passe</label>
				</label>
				<label for="password_bis" class='installationFormInput' class="textInputLabel">
					<input id="password_bis" type="password" name="password_bis" placeholder="&nbsp;" class="textInput"/>
					<label for="password_bis" class="textInputLabel">Confirmation</label>
				</label>
				<div class='button_container' style="text-align:center">
					<a id='submit' class='button_grey' href="menu.php">
						<i class="fas fa-times"></i>
						&nbsp;Annuler
					</a>
					<div id='submit' class='button_red' onclick="submit();">
						Enregistrer&nbsp;
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
