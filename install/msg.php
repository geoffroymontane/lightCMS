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
			<div id="installationFormTitle">Installation</div>
			<form action='index.php' method='post' id='installationForm'>
				<span id='fullMsg'>
					<?php echo $msg; ?>
				</span>
				<div class='button_container' style="text-align:center">
					<div id='submit' class='button_grey' onclick="submit();">
						<i class="fas fa-redo-alt"></i>
						&nbsp;Réessayer
					</div>
					<a id='submit' class='button_red' href="../index.php">
						<i class="fas fa-check"></i>
						&nbsp;Terminer
					</a>
				</div>

			</form>
		</div>
	</body>


</html>
