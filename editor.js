var selectedImage="";
var saved=true;

var containers=[];
var containerId=0;
var elementId=0;
var selectedElementId=null;


setInterval(function(){
	selectedElementId=document.activeElement.id;
},100);

class Container{
	constructor(classPC,classMobile){
		this.classPC=classPC;
		this.classMobile=classMobile;
		this.elements=[];
		this.id=containerId;
		containerId++;
	}	

	setClassPC(classPC){
		this.classPC=classPC;
	}

	setClassMobile(classMobile){
		this.classMobile=classMobile;
	}

	getEditorHTML(){
		var html="<div id='"+this.id+"' class='"+this.classPC+" "+this.classMobile+"'>";
		for(var i=0;i<this.elements.length;i++){
				html=html+this.elements[i].getEditorHTML();	
		}
		html=html+"</div><hr>";
		return html;
	}
}

class Element{
	constructor(classPC,classMobile,orderPC,orderMobile){
		this.classPC=classPC;	
		this.classMobile=classMobile;	
		this.orderPC=orderPC;	
		this.orderMobile=orderMobile;	
		this.content="";
		this.id=elementId;
		elementId++;
	}

	setContent(content){
		this.content=content;
	}

	getContent(content){
		return this.content;
	}

	getEditorHTML(){
		var html="<div id='"+this.id+"' contenteditable='true' class='"+this.classPC+" "+this.classMobile+" "+this.orderPC+" "+this.orderMobile+"'>"+this.content+"</div>";
		return html;
	}
	
}

function getContainerIndexFromElementId(id){
	for(var i=0;i<containers.length;i++){
		for(var n=0;n<containers[i].elements.length;n++){
			if(containers[i].elements[n].id==id){
				console.log(i);
				return i;
			}
		}
	}
	return null;
}

function moveUpContainer(){
	if(selectedElementId!=null){
		var index=getContainerIndexFromElementId(selectedElementId);
		if(index!=null){
			if(index!=0){
				console.log(index);
				var container=containers[index];
				containers[index]=containers[index-1];
				containers[index-1]=container;
			}
		}
	}
}

function moveDownContainer(){
	if(selectedElementId!=null){
		var index=getContainerIndexFromElementId(selectedElementId);
		if(index!=null){
			if(index<containers.length-1){
				var container=containers[index];
				containers[index]=containers[index+1];
				containers[index+1]=container;
			}
		}
	}
}

function buildEditorHTML(){
	var html="";
	for(var i=0;i<containers.length;i++){
		html=html+containers[i].getEditorHTML();
	}
	document.getElementById("editorTextContent").innerHTML=html;
}

function insertContainer(){
	var container=new Container("containerRowPC","containerColumnMobile");
	var element1=new Element("sixElementsPC","twelveElementsMobile","order1PC","order1Mobile");
	var element2=new Element("sixElementsPC","twelveElementsMobile","order2PC","order2Mobile");
	element1.setContent("Contenu");
	element2.setContent("Contenu");
	container.elements.push(element1,element2);
	containers.push(container);
	buildEditorHTML();

}



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

function showAddContainerPrompt(){

}

function hideAddContainerPrompt(){

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


