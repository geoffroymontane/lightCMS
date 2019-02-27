function compile(){
	var markdown=document.getElementById("editorTextContent").value;

	// Showdown compilation
	var html=new showdown.Converter().makeHtml(markdown);
	document.getElementById("editorPreviewContent").innerHTML=html;
}

function insertAtCursor (input, textToInsert) {
	const value = input.value;

	const start = input.selectionStart;
	const end = input.selectionEnd;

	input.value = value.slice(0, start) + textToInsert + value.slice(end);
	input.selectionStart = input.selectionEnd = start + textToInsert.length;
}

function bold(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '**' + textarea.value.slice(start, end) + '**' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 2;

	textarea.focus();
	compile();
}

function italic(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '*' + textarea.value.slice(start, end) + '*' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 1;

	textarea.focus();
	compile();
}

function header(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '#' + textarea.value.slice(start, end) + '' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 1;

	textarea.focus();
	compile();
}

function list(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '* ' + textarea.value.slice(start, end) + '' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 2;

	textarea.focus();
	compile();
}

function list_ordered(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '1. ' + textarea.value.slice(start, end) + '' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 3;

	textarea.focus();
	compile();
}

function blockquote(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '>' + textarea.value.slice(start, end) + '  ' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 3;

	textarea.focus();
	compile();
}

function link(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '[' + textarea.value.slice(start, end) + '](http://)' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 11;

	textarea.focus();
	compile();
}

function image(){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '![' + textarea.value.slice(start, end) + '](http://)' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 12;

	textarea.focus();
	compile();
}

function showImgPrompt(){
	document.getElementById("imgPrompt").style.visibility="visible";
	document.getElementById("imgPrompt").style.height="auto";
	document.getElementById("imgPrompt").focus();
}

function hideImgPrompt(){
	document.getElementById("imgPrompt").style.visibility="hidden";
	document.getElementById("imgPrompt").style.height="0";
	document.getElementById("editorTextContent").focus();
}

function showColorPrompt(){
	document.getElementById("colorPrompt").style.visibility="visible";
	document.getElementById("colorPrompt").style.height="auto";
	document.getElementById("colorPrompt").focus();
}

function hideColorPrompt(){
	document.getElementById("colorPrompt").style.visibility="hidden";
	document.getElementById("colorPrompt").style.height="0";
	document.getElementById("editorTextContent").focus();
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

	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;
	
	const txt = '<div class="img_container ' + classes_img_container + '"><img src="http://' + textarea.value.slice(start, end) + '" class="'+classes_img+'"></div>';
	textarea.value = textarea.value.slice(0, start) + txt  + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + txt.length + 1;

	textarea.focus();
	compile();
	hideImgPrompt();
}

function insertColor(name){
	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;
	
	const txt = '<' + name + '>' + textarea.value.slice(start, end) + '</' + name + '>';
	textarea.value = textarea.value.slice(0, start) + txt  + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + name.length + 2;

	textarea.focus();
	compile();
	hideColorPrompt();
}

window.onload=function(){
	compile();
};


