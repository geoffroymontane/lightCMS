<?php
	session_start();
	if(isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]==1){
		include("database.php");
		$success=0;

		$extension="";	
		$extensions=array("png","jpg","gif");

		$filename=explode("/",$_FILES["myfile"]["name"]);
		$filename=$filename[count($filename)-1];
		$filename=explode(".",$filename);
		$filename=$filename[count($filename)-1];

		for($i=0;$i<count($extensions);$i++){
			if($extensions[$i]==$filename){
				$extension=$extensions[$i];
				break;
			}
		}

		if(strcmp($extension,"")!=0){
			$query=$pdo->prepare("INSERT INTO lightcms_images (name,date,extension) VALUES (?,?,?);");
			$query->execute(array(basename($_FILES['myfile']['name']),time(),$extension));
			
			$query=$pdo->prepare("SELECT id FROM lightcms_images ORDER BY id DESC LIMIT 1;");
			$query->execute();
			$tab=$query->fetchAll();

			$id=$tab[0]["id"];
			$targetPath=getcwd()."/images/".$id.".".$extension;
			
			if(move_uploaded_file($_FILES['myfile']['tmp_name'], $targetPath)){
				$success = 1;
				$uploadedFile = $targetPath;
			}
			else{
				$msg="Erreur inconnue";
			}
		}
		else{
			$msg="Format invalide";
		}


		sleep(1);
	}
?>
<script type="text/javascript">parent.stopUpload("<?php echo $success;?>","<?php echo $msg;?>");</script>
