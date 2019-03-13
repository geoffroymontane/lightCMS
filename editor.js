var selectedImage="";
var saved=true;

function save(){
	saved=true;
	var html=document.getElementById("editorTextContent").innerHTML;
	var title=document.getElementById("title").value;
	document.getElementById("titleEditorSaveForm").value=title;
	document.getElementById("html").value=html;
	document.getElementById("editorSaveForm").submit();
}

function whenchange(){
	saved=false;
}

window.onbeforeunload=function(event) {
	if(!saved){
		event.returnValue='Voulez-vous vraiment quitter cette page sans enregistrer ?';
		return event.returnValue;
	}
	return;
};

function saveCursorPosition(){
	doSave();
	console.log("saved");
}

function restoreCursorPosition(){
	doRestore();
	console.log("restored");
}


function formatBlock(type){
	document.execCommand("formatBlock",false,type);
	whenchange();
}

function bold(event){
	saveCursorPosition();
	document.execCommand("bold",false,null);
	whenchange();
}

function italic(){
	saveCursorPosition();
	document.execCommand("italic",false,null);
	whenchange();
}

function underline(){
	saveCursorPosition();
	document.execCommand("underline",false,null);
}

function align(direction){
	saveCursorPosition();
	document.execCommand("justify"+direction,false,null);
	whenchange();
}

function header(){
	saveCursorPosition();
	formatBlock("h1");
}

function list(){
	saveCursorPosition();
	document.execCommand("insertUnorderedList",false,null);
	whenchange();
}

function list_ordered(){
	saveCursorPosition();
	document.execCommand("insertOrderedList",false,null);
	whenchange();
}

function undo(){
	saveCursorPosition();
	document.execCommand("undo",false,null);
	whenchange();
}

function redo(){
	saveCursorPosition();
	document.execCommand("redo",false,null);
	whenchange();
}


function showImgPrompt(){
	saveCursorPosition();
	document.getElementById("imgPrompt").style.display="block";
	document.getElementById("imgPicker").style.display="block";
	document.getElementById("imgPromptColumn1").style.display="none";
	document.getElementById("imgPromptColumn2").style.display="none";
	document.getElementById("imgPicker").focus();
}

function showImgPrompt_(){
	document.getElementById("imgPrompt").style.display="block";
	document.getElementById("imgPicker").style.display="none";
	document.getElementById("imgPromptColumn1").style.display="block"; document.getElementById("imgPromptColumn2").style.display="block"; document.getElementById("imgPrompt").focus();
}

function hideImgPrompt(){
	document.getElementById("imgPrompt").style.display="none";
	document.getElementById("imgPicker").style.display="block";
	document.getElementById("imgPromptColumn1").style.display="none";
	document.getElementById("imgPromptColumn2").style.display="none";
	//document.getElementById("editorTextContent").focus();
	restoreCursorPosition();
}

function showColorPrompt(){
	saveCursorPosition();
	//document.getElementById("editorTextContent").focus();
	document.getElementById("colorPrompt").style.display="block";
	document.getElementById("colorPrompt").focus();
}

function hideColorPrompt(){
	//document.getElementById("editorTextContent").focus();
	document.getElementById("colorPrompt").style.display="none";
	//document.getElementById("editorTextContent").focus();
	restoreCursorPosition();
}

function showLinkPrompt(){
	saveCursorPosition();
	document.getElementById("linkPrompt").style.display="block";
	document.getElementById("linkPrompt").focus();
}

function hideLinkPrompt(){
	document.getElementById("linkPrompt").style.display="none";
	restoreCursorPosition();
}

function insertLink(){
	console.log("test");
	var url=document.getElementById("link").value;
	console.log(url);
	hideLinkPrompt();
	document.execCommand("createLink",false,url);
	whenchange();
}

function insertImage(){
	var classes_img="";
	var classes_img_container="";
	var choices_img=["default","full","onequarter","onethird","onehalf","twothirds",
	    "floatleft","floatright","center","mobile_default","mobile_full",
	    "mobile_onequarter","mobile_onethird","mobile_onehalf","mobile_twothirds",
	    "mobile_center","mobile_floatleft","mobile_floatright"];
	var choices_img_container=["left","right","mobile_left","mobile_right"];

	choices_img.forEach(function(item,index,array){
			if(document.getElementById(item).checked){
				classes_img+=item+" ";
			}
	});

	choices_img_container.forEach(function(item,index,array){
		if(document.getElementById(item).checked){
			classes_img_container+=item+" ";
		}
	});

	const txt = '<div class="img_container ' + classes_img_container + '"><img src="images/' + selectedImage + '" class="'+classes_img+'"></div>';
	hideImgPrompt();
	document.execCommand("insertHTML",false,txt);
	whenchange();
}

function selectImage(img){
	//document.getElementById("editorTextContent").focus();
	selectedImage=img;
	showImgPrompt_();
}

function insertColor(color){
	//document.getElementById("editorTextContent").focus();
	hideColorPrompt();
	document.execCommand("foreColor",false,color);
}


