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
	document.getElementById("imgPrompt").style.height="100vh";
}

function hideImgPrompt(){
	document.getElementById("imgPrompt").style.visibility="hidden";
	document.getElementById("imgPrompt").style.height="0";
}

function insertImage(){
	var classes="";
	var choices=["default","full","onequarter","onethird","onehalf","twothirds",
	"left","right","floatleft","floatright","center","mobile_default","mobile_full",
	"mobile_onequarter","mobile_onethird","mobile_onehalf","mobile_twothirds",
	"mobile_left","mobile_right","mobile_center","mobile_nofloat"];

	choices.forEach(function(item,index,array){
		if(document.getElementById(item).checked){
			classes+=item+" ";
		}
	});

	var textarea=document.getElementById("editorTextContent");
				
	const start = textarea.selectionStart;
	const end = textarea.selectionEnd;

	textarea.value = textarea.value.slice(0, start) + '<img src="http://' + textarea.value.slice(start, end) + '" class="'+classes+'">' + textarea.value.slice(end);
	textarea.selectionStart = textarea.selectionEnd = start + 27 + classes.length;

	textarea.focus();
	compile();
	hideImgPrompt();
}

window.onload=function(){
	compile();
};


