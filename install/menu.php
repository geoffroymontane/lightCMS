<html>

	<head>
		
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="../fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="../ui.css" rel="stylesheet" type="text/css">
		<link href="../global.css" rel="stylesheet" type="text/css">
		<link href="install.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	</head>

	<body id="installationBody">

		<div id="installationContent">
			<div id="installationFormTitle">Installation : menu</div>
			<form action='index.php' method='post' id='installationForm'>
				<div class='button_container' style="text-align:center">
					<a id='submit' class='button_grey' style="width:70%;" href="index.php?database">
						<i class="fas fa-database"></i>
						&nbsp;Installation
					</a>
				</div>
				<div class='button_container' style="text-align:center">
					<a id='submit' class='button_grey' style="width:70%"  href="index.php?signup">
						<i class="fas fa-user-alt"></i>
						&nbsp;Créer un compte
					</a>
				</div>
				<div class='button_container' style="text-align:center">
					<a id='submit' class='button_red' style="width:70%;" href="../connection.php?disconnect">
						<i class="fas fa-sign-out-alt"></i>
						&nbsp;Quitter
					</a>
				</div>

			</form>
		</div>
	</body>


</html>
