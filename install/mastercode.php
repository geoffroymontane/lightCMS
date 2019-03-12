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
			<div id="installationFormTitle">Installation : code maître</div>
			<form action='index.php' method='post' id='installationForm'>
				<label for="mastercode" class='installationFormInput' class="textInputLabel">
					<input id="mastercode" name="mastercode" type="password" placeholder="&nbsp;" class="textInput"/>
					<label for="mastercode" class="textInputLabel">Code maître</label>
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
