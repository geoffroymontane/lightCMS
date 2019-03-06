<?php
	session_start();
	if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
		include("database.php");

		//Save existing content
		if(isset($_GET["save"]) && isset($_POST["contentId"]) && strcmp($_POST["contentId"],"none")!=0 && isset($_POST["markdown"]) && isset($_POST["html"])){
			$query=$pdo->prepare("UPDATE lightcms_contents SET markdown=?,html=?,name=? WHERE id=?;");
			$query->execute(array($_POST["markdown"],$_POST["html"],$_POST["title"],$_POST["contentId"]));

			$id=$_POST["contentId"];
			$markdown=$_POST["markdown"];
			$title=$_POST["title"];
			$msg="Sauvegardé avec succès";
		}
		//Save new content
		else if(isset($_GET["save"]) && isset($_POST["markdown"]) && isset($_POST["html"])){
			$query=$pdo->prepare("INSERT INTO lightcms_contents (markdown, html, date, name) VALUES (?,?,?,?)");
			$query->execute(array($_POST["markdown"],$_POST["html"],time(),$_POST["title"]));

			$query=$pdo->prepare("SELECT id FROM lightcms_contents ORDER BY id DESC LIMIT 1;");
			$query->execute();
			$tab=$query->fetchAll();

			$id=$tab[0]["id"];
			$markdown=$_POST["markdown"];
			$title=$_POST["title"];
			$msg="Sauvegardé avec succès";
		}
		//Show existing content
		else if(isset($_GET["id"])){
			$query=$pdo->prepare("SELECT name,date,markdown FROM lightcms_contents WHERE id=?;");
			$query->execute(array($_GET["id"]));
			$tab=$query->fetchAll();
			
			$id=$_GET["id"];
			$title=$tab[0]["name"];
			$markdown=$tab[0]["markdown"];
		}
		//New content
		else{
			$id="none";
			$title="Nouveau contenu";
			$markdown="";
		}
	}
?>

<html>

	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="fonts/fonts.css" rel="stylesheet" type="text/css">
		<link href="global.css" rel="stylesheet" type="text/css">
		<link href="editor.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="showdown/dist/showdown.js"></script>
		<script src="editor.js"></script>
		
	</head>

	<body>
		<div id="colorPrompt" class="modal">
			<div id="colorPromptGrid" class="modal-content">
				<div class="colorPromptIcon" onclick="hideColorPrompt()" style="border:1px solid #db2828"><span class="colorPromptTimes">&times;</span></div>
				<div class="color" id="red" onclick="insertColor('red')"></div>
				<div class="color" id="orange" onclick="insertColor('orange')"></div>
				<div class="color" id="yellow" onclick="insertColor('yellow')"></div>
				<div class="color" id="olive" onclick="insertColor('olive')"></div>
				<div class="color" id="green" onclick="insertColor('green')"></div>
				<div class="color" id="teal" onclick="insertColor('teal')"></div>
				<div class="color" id="blue" onclick="insertColor('blue')"></div>
				<div class="color" id="violet" onclick="insertColor('violet')"></div>
				<div class="color" id="purple" onclick="insertColor('purple')"></div>
				<div class="color" id="pink" onclick="insertColor('pink')"></div>
				<div class="color" id="brown"onclick="insertColor('brown')"></div>
				<div class="color" id="grey" onclick="insertColor('grey')"></div>
				<div class="color" id="black" onclick="insertColor('black')"></div>
			</div>
		</div>
		<div id="imgPrompt" class="modal">
			<form id="imgPromptForm" class="modal-content">
				<iframe id="imgPicker" src="imagesDropdown.php"></iframe>
				<div class="imgPromptColumn" id="imgPromptColumn1">
					<span><b>PC</b></span><br><br>
					<span><b>Largeur</b></span><br>
					<div class="checkbox_container">
						<input id="default" class="checkbox" type="radio" name="1" checked="checked">
						<div class="checkmark"></div>
						Aussi large que possible sans dépasser sa taille réelle
					</div>
					<div class="checkbox_container">
						<input id="full" class="checkbox" type="radio" name="1">
						<div class="checkmark"></div>
						Aussi large que la page
					</div>
					<div class="checkbox_container">
						<input id="onequarter" class="checkbox" type="radio" name="1">
						<div class="checkmark"></div>
						 25% de la largeur de la page si possible sans dépasser sa taille réelle
					</div>
					<div class="checkbox_container">
						<input id="onethird" class="checkbox" type="radio" name="1">
						<div class="checkmark"></div>
						33%
					</div>
					<div class="checkbox_container">
						<input id="onehalf" class="checkbox" type="radio" name="1">
						<div class="checkmark"></div>
						 50%
					</div>
					<div class="checkbox_container">
						<input id="twothirds" class="checkbox" type="radio" name="1">
						<div class="checkmark"></div>
						 66%
					</div>
					<br>
					<span><b>Alignement</b></span><br>
					<div class="checkbox_container">
						<input id="center" class="checkbox" type="radio" name="2" checked="checked">
						<div class="checkmark"></div>
						Centre
					</div>
					<div class="checkbox_container">
						<input id="left" class="checkbox" type="radio" name="2">
						<div class="checkmark"></div>
						Gauche
					</div>
					<div class="checkbox_container">
						<input id="right" class="checkbox" type="radio" name="2">
						<div class="checkmark"></div>
						Droite
					</div>
					<div class="checkbox_container">
						<input id="floatleft" class="checkbox" type="radio" name="2">
						<div class="checkmark"></div>
						Flotte à gauche du texte
					</div>
					<div class="checkbox_container">
						<input id="floatright" class="checkbox" type="radio" name="2">
						<div class="checkmark"></div>
						Flotte à droite du texte
					</div>
					<br>
					<div class="button_red" onclick="hideImgPrompt()">Fermer</div>
				</div>
				<div class="imgPromptColumn" id="imgPromptColumn2">
					<span><b>MOBILE</b></span><br><br>
					<span><b>Largeur</b></span><br>
					<div class="checkbox_container">
						<input id="mobile_default" class="checkbox" type="radio" name="3" checked="checked">
						<div class="checkmark"></div>
						Aussi large que possible sans dépasser sa taille réelle
					</div>
					<div class="checkbox_container">
						<input id="mobile_full" class="checkbox" type="radio" name="3">
						<div class="checkmark"></div>
						Aussi large que la page
					</div>
					<div class="checkbox_container">
						<input id="mobile_onequarter" class="checkbox" type="radio" name="3">
						<div class="checkmark"></div>
						25% de la largeur de la page si possible sans dépasser sa taille réelle
					</div>
					<div class="checkbox_container">
						<input id="mobile_onethird" class="checkbox" type="radio" name="3">
						<div class="checkmark"></div>
						 33%
					</div>
					<div class="checkbox_container">
						<input id="mobile_onehalf" class="checkbox" type="radio" name="3">
						<div class="checkmark"></div>
						 50%
					</div>
					<div class="checkbox_container">
						<input id="mobile_twothirds" class="checkbox" type="radio" name="3">
						<div class="checkmark"></div>
						 66%
					</div>
					<br>
					<span><b>Alignement</b></span><br>
					<div class="checkbox_container">
						<input id="mobile_center" class="checkbox" type="radio" name="4" checked="checked"> 
						<div class="checkmark"></div>
						Centre
					</div>
					<div class="checkbox_container">
						<input id="mobile_left" class="checkbox" type="radio" name="4">
						<div class="checkmark"></div>
						Gauche
					</div>
					<div class="checkbox_container">
						<input id="mobile_right" class="checkbox" type="radio" name="4">
						<div class="checkmark"></div>
						Droite
					</div>
					<div class="checkbox_container">
						<input id="mobile_floatleft" class="checkbox" type="radio" name="4">
						<div class="checkmark"></div>
						Flotte à gauche du texte
					</div>
					<div class="checkbox_container">
						<input id="mobile_floatright" class="checkbox" type="radio" name="4">
						<div class="checkmark"></div>
						Flotte à droite du texte
					</div>
					<br>
					<div class="button_green" onclick="insertImage()">Insérer</div>
				</div>
			</form>
			<div style="display:flex">
			</div>
		</div>
		</section>
		<div style="margin-left:16px;">
			<b>ID : </b> <?php echo $id;?>
			<input id="title" value="<?php echo $title; ?>"/>
		</div>
		<section id="editor">
			<div id="toolbar">
				<a class="icon" onclick="bold()">
					<i class="fas fa-bold"></i>
				</a>
				<a class="icon" onclick="italic()">
					<i class="fas fa-italic"></i>
				</a>
				<a class="icon" onclick="header()">
					<i class="fas fa-heading"></i>
				</a>
				<a class="icon" onclick="showColorPrompt()">
					<i class="fas fa-palette"></i>
				</a>
				<a class="separator">|</a>
				<a class="icon" onclick="list()">
					<i class="fas fa-list-ul"></i>
				</a>
				<a class="icon" onclick="list_ordered()">
					<i class="fas fa-list-ol"></i>
				</a>
				<a class="separator">|</a>
				<a class="icon" onclick="blockquote()">
					<i class="fas fa-quote-left"></i>
				</a>
				<a class="icon">
					<i class="fas fa-table"></i>
				</a>
				<a class="separator">|</a>
				<a class="icon" onclick="link()">
					<i class="fas fa-link"></i>
				</a>
				<a class="icon" onclick="showImgPrompt()">
					<i class="far fa-image"></i>
				</a>
			</div>

			<section id="editorBottom">
				<div id="editorText">
					<form action="editor.php?save=1" method="POST" id="editorSaveForm">
						<input type="hidden" name="title" value="" id="titleEditorSaveForm"/>
						<input type="hidden" name="contentId" value="<?php echo $id; ?>"/>
						<input type="hidden" name="html" id="html" value=""/>
						<textarea id="editorTextContent" name="markdown" onkeyup="compile()" onChange="compile()" value=""><?php echo addslashes($markdown); ?></textarea>
						<div class="button" onclick="save()">
							<i class="fas fa-save"></i>
							Sauvegarder
						</div>
						<a class="button_grey" href="contents.php">
							<i class="fas fa-ban"></i>
							Annuler
						</a>
						<div id="msg"><?php echo $msg; ?></div>
					</form>
				</div>
				<div id="editorPreview"><div id="editorPreviewContent"></div></div>
			</section>
		</section>

	</body>






	</html>
