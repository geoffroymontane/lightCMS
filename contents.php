<?php
	session_start();
	if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
		include("database.php");

		$query=$pdo->prepare("SELECT id,name,date FROM lightcms_contents ORDER BY date DESC");
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
		<link href="ui.css" rel="stylesheet" type="text/css">
		<link href="contents.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="contents.js"></script>
		
	</head>
	<body>
		<a class="button" href="editor.php">
			<i class="fas fa-plus"></i>
			&nbsp;Ajouter
		</a>
		<div id="contentsList">
			<table>
				<tr class="trFirst">
					<th class="thFirst thLeft">ID</th>
					<th class="thFirst">Titre</th>
					<th class="thFirst thRight">Date</th>
				</tr>
			<?php
				for($i=0;$i<count($tab);$i++){
					echo "<tr onclick='edit(".$tab[$i]["id"].")'>";
					echo "<td>".$tab[$i]["id"]."</td>";
					echo "<td>".$tab[$i]["name"]."</td>";
					echo "<td>".date("d/m/o",$tab[$i]["date"])."</td>";
					echo "</tr>";
				}
			?>
			</table>
		</div>
	</body>

</html>
