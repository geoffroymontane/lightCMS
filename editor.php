<?php
	session_start();
	if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
		include("database.php");

		//Save existing content
		if(isset($_GET["save"]) && isset($_POST["contentId"]) && strcmp($_POST["contentId"],"none")!=0 && isset($_POST["html"])){
			$query=$pdo->prepare("UPDATE lightcms_contents SET html=?,name=? WHERE id=?;");
			$query->execute(array($_POST["html"],$_POST["title"],$_POST["contentId"]));

			$id=$_POST["contentId"];
			$title=$_POST["title"];
			$html=$_POST["html"];
			$msg="Sauvegardé avec succès";
		}
		//Save new content
		else if(isset($_GET["save"]) && isset($_POST["html"])){
			$query=$pdo->prepare("INSERT INTO lightcms_contents (html, date, name) VALUES (?,?,?)");
			$query->execute(array($_POST["html"],time(),$_POST["title"]));


			$query=$pdo->prepare("SELECT id FROM lightcms_contents ORDER BY id DESC LIMIT 1;");
			$query->execute();
			$tab=$query->fetchAll();

			$id=$tab[0]["id"];
			$title=$_POST["title"];
			$html=$_POST["html"];
			$date=$_POST["date"];
			$msg="Sauvegardé avec succès";
		}
		//Show existing content
		else if(isset($_GET["id"])){
			$query=$pdo->prepare("SELECT name,date,html FROM lightcms_contents WHERE id=?;");
			$query->execute(array($_GET["id"]));
			$tab=$query->fetchAll();
			
			$id=$_GET["id"];
			$title=$tab[0]["name"];
			$date=$tab[0]["date"];
			$html=$tab[0]["html"];
		}
		//New content
		else{
			$id="none";
			$title="";
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
		<link href="editor.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="editor_selection.js"></script>
		<script src="editor.js"></script>
		
	</head>

	<body>

		<!-- COLOR POP-UP -->
		<div id="colorPrompt" class="modal">
			<div id="colorPromptGrid" class="modal-content">
				<div class="colorPromptIcon" onmousedown="hideColorPrompt()" style="border:1px solid #db2828"><span class="colorPromptTimes">&times;</span></div>
				<div class="color" id="red" onmousedown="insertColor('#db2828')"></div>
				<div class="color" id="orange" onmousedown="insertColor('#f2711c')"></div>
				<div class="color" id="yellow" onmousedown="insertColor('#fbbd08')"></div>
				<div class="color" id="olive" onmousedown="insertColor('#b5cc18')"></div>
				<div class="color" id="green" onmousedown="insertColor('#21ba45')"></div>
				<div class="color" id="teal" onmousedown="insertColor('#00b5ad')"></div>
				<div class="color" id="blue" onmousedown="insertColor('#2185d0')"></div>
				<div class="color" id="violet" onmousedown="insertColor('#6435c9')"></div>
				<div class="color" id="purple" onmousedown="insertColor('#a333c8')"></div>
				<div class="color" id="pink" onmousedown="insertColor('#e03997')"></div>
				<div class="color" id="brown"onmousedown="insertColor('#a5673f')"></div>
				<div class="color" id="grey" onmousedown="insertColor('#767676')"></div>
				<div class="color" id="black" onmousedown="insertColor('#000')"></div>
			</div>
		</div>

		<!-- LINK POP-UP -->
		<div id="linkPrompt" class="modal">
			<div id="linkPromptContent" class="modal-content">
				<br>
				<label id="linkLabel" for="link" class='textInputContainer'>
					<input id="link" class="textInput" placeholder="&nbsp;" value=""/>
					<label for="link" class="textInputLabel">Lien</label>
				</label>
				<div class="button_container" style="text-align:center;">
					<div class="button_grey" onmousedown="hideLinkPrompt()">
						<i class="fas fa-ban"></i>
						&nbsp;Annuler
					</div>
					<div class="button_red" onmousedown="insertLink()">
						<i class="fas fa-plus"></i>
						&nbsp;Insérer
					</div>
				</div>
			</div>
		</div>

		<!-- IMAGE POP-UP -->
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
					<div class="button_grey" onmousedown="hideImgPrompt()">
						<i class="fas fa-ban"></i>
						&nbsp;Fermer
					</div>
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
					<div class="button_red" onmousedown="insertImage()">
						<i class="fas fa-plus"></i>
						&nbsp;Insérer
					</div>
				</div>
			</form>
			<div style="display:flex">
			</div>
		</div>
		</section>
		<section id="editor">
			<div id="metadata">
				<div id="metadata_1">
					<label for="title" class='textInputContainer'>
						<input id="title" class="textInput" placeholder="&nbsp;" value="<?php echo $title; ?>"/>
						<label for="title" class="textInputLabel">Titre</label>
					</label>
				</div>
				<div id="metadata_2">
					<b>ID : </b> <?php echo $id;?><br>
					<b>Date : </b> <?php echo date("d/m/y",$date);?><br><br>
				</div>
			</div>
			<div id="editorButtons">
				<!--<span id="msg"><?php echo $msg; ?></span>&nbsp;&nbsp;-->
				<div class="button_red" style="margin-right:16px" onmousedown="save()">
					<i class="fas fa-save"></i>
					&nbsp;Sauvegarder
				</div>
				<a class="button_grey" href="contents.php">
					<i class="fas fa-ban"></i>
					&nbsp;Annuler
				</a>
			</div>
			<div id="toolbar">
				<a class="icon" id="cool" onmousedown="bold(event)">
					<i class="fas fa-bold"></i>
				</a>
				<a class="icon" onmousedown="italic()">
					<i class="fas fa-italic"></i>
				</a>
				<a class="icon" onmousedown="underline()">
					<i class="fas fa-underline"></i>
				</a>
				<a class="icon" onmousedown="header()">
					<i class="fas fa-heading"></i>
				</a>
				<a class="icon" onmousedown="showColorPrompt()">
					<i class="fas fa-palette"></i>
				</a>
				<a class="separator">|</a>
				<a class="icon" onmousedown="align('Right')">
					<i class="fas fa-align-right"></i>
				</a>
				<a class="icon" onmousedown="align('Center')">
					<i class="fas fa-align-center"></i>
				</a>
				<a class="icon" onmousedown="align('Left')">
					<i class="fas fa-align-left"></i>
				</a>
				<a class="icon" onmousedown="align('Full')">
					<i class="fas fa-align-justify"></i>
				</a>
				<a class="separator">|</a>
				<a class="icon" onmousedown="list()">
					<i class="fas fa-list-ul"></i>
				</a>
				<a class="icon" onmousedown="list_ordered()">
					<i class="fas fa-list-ol"></i>
				</a>
				<a class="separator">|</a>
				<a class="icon" onmousedown="showLinkPrompt()">
					<i class="fas fa-link"></i>
				</a>
				<a class="icon" onmousedown="showImgPrompt()">
					<i class="far fa-image"></i>
				</a>
				<a class="separator">|</a>
				<a class="icon" onmousedown="undo()">
					<i class="fas fa-undo"></i>
				</a>
				<a class="icon" onmousedown="redo()">
					<i class="fas fa-redo-alt"></i>
				</a>
			</div>

			<section id="editorBottom">
				<div id="editorText">
					<form action="editor.php?save=1" method="POST" id="editorSaveForm">
						<input type="hidden" name="title" value="" id="titleEditorSaveForm"/>
						<input type="hidden" name="contentId" value="<?php echo $id; ?>"/>
						<input type="hidden" name="html" id="html" value=""/>
						<div id="editorTextContent">
							<?php echo $html; ?>
						</div>
						<div class="button_red" onclick="insertContainer()">
							<i class="fas fa-plus"></i>
							&nbsp;Insérer un nouveau conteneur						
						</div>
						<div class="button_grey" onclick="moveUpContainer()">
							<i class="fas fa-arrow-up"></i>
						</div>
						<div class="button_grey" onclick="moveDownContainer()">
							<i class="fas fa-arrow-down"></i>
						</div>
					</form>
				</div>
			</section>
		</section>

	</body>






	</html>
