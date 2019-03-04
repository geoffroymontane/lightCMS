function stopUpload(success,msg){
	if(success=="1"){
		window.location.href="imagesDropdown.php";
	}
	else{
		document.getElementById("addImageText").innerHTML=msg;
	}
}

function startUpload(){
	document.getElementById("fileForm").submit();	
}
