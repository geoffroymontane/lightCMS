<?php
	session_start();
	if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
		include("database.php");

		$day=date("dmy");
		$month="**".date("my");
		$month_=date("my");
		$year=date("y");

		$months=array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

		// Get global monthly entries
		$query=$pdo->prepare("SELECT period,count FROM lightcms_statistics WHERE (period LIKE '**%".$year."' OR period LIKE '**%".strval(intval($year)-1)."') AND type LIKE 'global' ORDER BY period");
		$query->execute();
		$tab1=$query->fetchAll();

		// Get global daily entries
		$query=$pdo->prepare("SELECT period,count FROM lightcms_statistics WHERE period NOT LIKE '**%'AND period LIKE '%".$month_."' AND type LIKE 'global' ORDER BY period");
		$query->execute();
		$tab2=$query->fetchAll();

		// Get contents views count today
		$query=$pdo->prepare("SELECT SUM(count) FROM lightcms_statistics WHERE period LIKE ? AND type LIKE 'content'");
		$query->execute(array($day));
		$todayContentsViews=$query->fetchColumn();

		$global=array();
		for($i=0;$i<count($tab1);$i++){
			$global[$tab1[$i]["period"]]=$tab1[$i]["count"];
		}
		for($i=0;$i<count($tab2);$i++){
			$global[$tab2[$i]["period"]]=$tab2[$i]["count"];
		}


		// Get max monthly global entry in order to build the chart
		$max=intval($tab1[0]["count"]);
		for($i=0;$i<count($tab1);$i++){
			if(intval($tab1[$i]["count"])>$max){
				$max=intval($tab1[$i]["count"]);
			}
		}

		// Build chart data to show
		$data=array();
		$n=0;
		$month_int=intval(date("m"));
		$m=$month_int;
		$y=intval($year);
		while($n<6){
			array_push($data,array("label"=>$months[$m],"value"=>$global["**".substr("0".strval($m),-2).$y]));
			$m--;
			if($m==0){
				$y--;
				$m=12;
			}
			$n++;
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
		<link href="statistics.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		
	</head>
	<body>

		<div class="topContainer">

			<div class="dataContainer">
				Visiteurs aujourd'hui
				<hr>
				<h2><?php echo $global[$day]; ?></h2>
			</div>

			<div class="dataContainer">
				Pages vues aujourd'hui 
				<hr>
				<h2><?php echo $todayContentsViews; ?></h2>
			</div>


			<div class="dataContainer">
				Visiteurs ce mois-ci
				<hr>
				<h2><?php echo $global[$month]; ?></h2>
			</div>
		</div>

		<div id="chartDataContainer" class="dataContainer">
			Visiteurs par mois
			<hr>
			<div id="chartContainer">
				<div class="chart">
					<div class="legendy">
							<div class="value" style="top:0"><?php echo $max; ?></div>
							<div class="value" style="top:100px"><?php echo 4*$max/5; ?></div>
							<div class="value" style="top:200px"><?php echo 4*$max/5; ?></div>
							<div class="value" style="top:300px"><?php echo 4*$max/5; ?></div>
							<div class="value" style="top:400px"><?php echo 4*$max/5; ?></div>
							<div class="value" style="top:500px">0</div>
					</div>
					<div class="chartRight">
						<div class="chartContent">
							<div class="bar _red" style="height:<?php echo 500/$max*$data[5]["value"]; ?>px"></div>
							<div class="bar _orange" style="height:<?php echo 500/$max*$data[4]["value"]; ?>px"></div>
							<div class="bar _yellow" style="height:<?php echo 500/$max*$data[3]["value"]; ?>px"></div>
							<div class="bar _olive" style="height:<?php echo 500/$max*$data[2]["value"]; ?>px"></div>
							<div class="bar _green" style="height:<?php echo 500/$max*$data[1]["value"]; ?>px"></div>
							<div class="bar _teal" style="height:<?php echo 500/$max*$data[0]["value"]; ?>px"></div>

						</div>
							<div class="legendx">
								<div class="legend"><?php echo $data[5]["label"];?></div>	
								<div class="legend"><?php echo $data[4]["label"];?></div>	
								<div class="legend"><?php echo $data[3]["label"];?></div>	
								<div class="legend"><?php echo $data[2]["label"];?></div>	
								<div class="legend"><?php echo $data[1]["label"];?></div>	
								<div class="legend"><?php echo $data[0]["label"];?></div>	
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</div>	
	</body>

</html>
