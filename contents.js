
// List of selected contents (checkbox)
var contentsSelected=[];

// Start editing content
function edit(id){
	window.location="editor.php?id="+id;
}



/*

Toggle delete button when some contents are selected
and update contentsSelected
 
*/
function unableDeleteButton(){
	document.getElementById("deleteButton").classList.remove("button_inactive");
	document.getElementById("deleteButton").classList.add("button_grey");
}

function disableDeleteButton(){
	document.getElementById("deleteButton").classList.add("button_inactive");
	document.getElementById("deleteButton").classList.remove("button_grey");
}

function checkboxOnchange(event){
	var checkbox=event.currentTarget || event.srcElement;
	if(checkbox.checked){
		contentsSelected.push(checkbox.id);
	}
	else{
		contentsSelected.pop(contentsSelected.indexOf(checkbox.id));
	}

	document.getElementById("count").innerHTML=contentsSelected.length;

	if(contentsSelected.length>0){
		unableDeleteButton();
	}
	else{
		disableDeleteButton();
	}
}


/*

Delete selected contents

*/
function deleteContents(){
	var str="";
	for(var i=0;i<contentsSelected.length;i++){
		str=str+"-"+contentsSelected[i];	
	}

	if(contentsSelected.length>0){
		str=str.substring(1);
	}
	
	window.location="contents.php?delete="+str;
}
