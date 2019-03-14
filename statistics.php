<?php
	session_start();
	if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
		include("database.php");

		$query=$pdo->prepare("SELECT period,count FROM lightcms_statistics WHERE period LIKE %19");
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
		<link href="statistics.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		
	</head>
	<body>

		<div class="topContainer">

			<div class="dataContainer">
				Visiteurs aujourd'hui
				<hr>
				<h2>33</h2>
			</div>

			<div class="dataContainer">
				Pages vues aujourd'hui 
				<hr>
				<h2>254</h2>
			</div>


			<div class="dataContainer">
				Visiteurs ce mois-ci
				<hr>
				<h2>33</h2>
			</div>
		</div>

		<div id="chartDataContainer" class="dataContainer">
			Visiteurs par mois
			<hr>
			<div id="chartContainer">
				<div class="chart">
					<div class="legendy">
							<div class="value" style="top:0">500</div>
							<div class="value" style="top:100px">400</div>
							<div class="value" style="top:200px">300</div>
							<div class="value" style="top:300px">200</div>
							<div class="value" style="top:400px">100</div>
							<div class="value" style="top:500px">0</div>
					</div>
					<div class="chartRight">
						<div class="chartContent">
							<div class="bar _red" style="height:400px"></div>
							<div class="bar _orange" style="height:300px"></div>
							<div class="bar _yellow" style="height:200px"></div>
							<div class="bar _olive" style="height:200px"></div>
							<div class="bar _green" style="height:200px"></div>
							<div class="bar _teal" style="height:200px"></div>

						</div>
							<div class="legendx">
							<div class="legend">Janvier</div>	
							<div class="legend">Février</div>	
							<div class="legend">Mars</div>	
							<div class="legend">Avril</div>	
							<div class="legend">Mai</div>	
							<div class="legend">Juin</div>	
						</div>
					</div>
				</div>	
			</div>	
		</div>	
	</body>

</html>
