

function toggleShowMenu(){
	if(document.getElementById("menu").style.display=="block"){
		document.getElementById("menu").style.display="none";
	}
	else{
		document.getElementById("menu").style.display="block";
	}
}

function goTo(url){
	document.getElementById("content").src=url;
	if(window.innerWidth<=1000){
		toggleShowMenu();
	}
}
