function showAddImage(){
	document.getElementById("addImage").style.display="block";
}

function hideAddImage(){
	document.getElementById("addImage").style.display="none";
}

function stopUpload(success,msg){
	if(success=="1"){
		hideAddImage();
	}
	else{
		document.getElementById("addImageText").innerHTML=msg;
	}
	window.location.href="images.php";
}

function startUpload(){
	document.getElementById("fileForm").submit();	
}
