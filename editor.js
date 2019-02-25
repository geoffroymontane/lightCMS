function compile(){
	document.getElementById("editorPreviewContent").innerHTML=new showdown.Converter().makeHtml(document.getElementById("editorTextContent").value);
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

window.onload=function(){
	compile();
};


