<?php
	session_start();
	if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
		include("database.php");

		$query=$pdo->prepare("SELECT * FROM lightcms_images ORDER BY date DESC");
		$query->execute();
		$tab=$query->fetchAll();
	}
?>

<html>
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="global.css" rel="stylesheet" type="text/css">
		<link href="imagesDropdown.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="imagesDropdown.js"></script>
		
	</head>
	<body>
		<label class="button_select" for="filePicker">Ajouter</label>
		<div id="addImageText">Sélectionner une image afin de la mettre en ligne</div>
		<form id="fileForm" action="uploadImages.php" target="iframe" method="post" enctype="multipart/form-data">
			<input type="file" id="filePicker" name="myfile" onchange="startUpload()">
		</form>
		<iframe style="display:none;" name="iframe"></iframe>
		<div id="imagesList">
			<?php
				if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
					for($i=0;$i<count($tab);$i++){
						echo "<div class='image_container'><img onclick='parent.selectImage(\"".$tab[$i]["id"].".".$tab[$i]["extension"]."\")' src='images/".$tab[$i]["id"].".".$tab[$i]["extension"]."' class='image'></div>";
					}
				}
			?>
		</div>
	</body>

</html>
