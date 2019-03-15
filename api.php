<?php

$path="lightCMS/";
echo "<link rel='stylesheet' type='text/css' href='".$path."global.css'>";
echo "<link href='".$path."fonts/fonts.css' rel='stylesheet' type='text/css'>";

function connectToDatabase(){
	global $path;
	if(file_exists($path."credentials.php")){
		include($path."credentials.php");
		$DBconnect = "mysql:dbname=".$DBName.";host=".$DBhost;
		$pdo = new PDO($DBconnect, $DBowner, $DBpw);
		return $pdo;
	}
	else{
		echo "Database error";
	}
}

function handleStatistics($pdo,$id){
	$day=date("dmy");
	$month="**".date("my");
	$ip=$_SERVER['REMOTE_ADDR'];

	/* 

	Monthly

	*/
	// Create monthly global entry (website visitors) if not exists	
	$query=$pdo->prepare("
	INSERT IGNORE INTO lightcms_statistics (period,type,target,count) 
	VALUES (?,'global',0,0);");

	$query->execute(array($month));

	// Create monthly content entry (content views) if not exists	
	$query=$pdo->prepare("
	INSERT IGNORE INTO lightcms_statistics (period,type,target,count) 
	VALUES (?,'content',?,0);");

	$query->execute(array($month,$id));

	// Check if this IP has been registered this month
	$query=$pdo->prepare("
	SELECT COUNT(*) FROM lightcms_visitors WHERE ip=? AND period=?;");

	$query->execute(array($ip,$month));
	$count=$query->fetchColumn();

	// If not, add it to lightcms_visitors and increment global entry
	if($count==0){
		$query=$pdo->prepare("
		INSERT INTO lightcms_visitors (period,ip) VALUES (?,?);
	 	UPDATE lightcms_statistics SET count=count+1 WHERE period
		LIKE ? AND type LIKE 'global';");

		$query->execute(array($month,$ip,$month));
	}

	// In any case, increment content entry because it is a new view
	$query=$pdo->prepare("
	UPDATE lightcms_statistics SET count=count+1 WHERE period LIKE ?
	AND type LIKE 'content' AND target LIKE ?;");

	$query->execute(array($month,$id));
	
	/* 

	Daily

	*/
	// Create daily global entry (website visitors) if not exists	
	$query=$pdo->prepare("
	INSERT IGNORE INTO lightcms_statistics (period,type,target,count)
	VALUES (?,'global',0,0);");

	$query->execute(array($day));

	// Create daily content entry (content views) if not exists	
	$query=$pdo->prepare("
	INSERT IGNORE INTO lightcms_statistics (period,type,target,count)
	VALUES (?,'content',?,0);");

	$query->execute(array($day,$id));
	
	// Check if this IP has been registered today
	$query=$pdo->prepare("
	SELECT COUNT(*) FROM lightcms_visitors WHERE ip=? AND period=?;");

	$query->execute(array($ip,$day));
	$count=$query->fetchColumn();

	// If not, add it to lightcms_visitors and increment global entry
	if($count==0){
		$query=$pdo->prepare("
		INSERT INTO lightcms_visitors (period,ip) VALUES (?,?);
		UPDATE lightcms_statistics SET count=count+1 WHERE period LIKE
		? AND type LIKE 'global';");

		$query->execute(array($day,$ip,$day));
	}

	// In any case, increment content entry because it is a new view
	$query=$pdo->prepare("
	UPDATE lightcms_statistics SET count=count+1 WHERE period LIKE ?
	AND type LIKE 'content' AND target LIKE ?;");

	$query->execute(array($day,$id));
}

function getContentById($id){
	global $path;

	$pdo=connectToDatabase();

	$query=$pdo->prepare(
	"SELECT id,html FROM lightcms_contents WHERE id=?");

	$query->execute(array($id));
	$tab=$query->fetchAll();

	if(count($tab)>0){
		$tab[0]["html"]=str_replace("src='","src='".$path
			,$tab[0]["html"]);
		$tab[0]["html"]=str_replace('src="','src="'.$path
			,$tab[0]["html"]);

		echo $tab[0]["html"];
	}
	else{
		echo "Error : no such content";
	}

	handleStatistics($pdo,$tab[0]["id"]);
}

function getContentByName($name){
	global $path;

	$pdo=connectToDatabase();
	$query=$pdo->prepare(
	"SELECT id,html FROM lightcms_contents WHERE name LIKE ? LIMIT 1");

	$query->execute(array($name));
	$tab=$query->fetchAll();

	if(count($tab)>0){
		$tab[0]["html"]=str_replace("src='","src='".$path
			,$tab[0]["html"]);
		$tab[0]["html"]=str_replace('src="','src="'.$path
			,$tab[0]["html"]);

		echo $tab[0]["html"];
	}
	else{
		echo "Error : no such content";
	}

	handleStatistics($pdo,$tab[0]["id"]);
}

?>

