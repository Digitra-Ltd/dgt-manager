function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
/*Afficher/Masquer grace aux css et javascript*/
function hideDiv() {
	if (document.getElementById) { // DOM3 = IE5, NS6
		document.getElementById('hideShow').style.visibility = 'hidden';
	}
	else {
		if (document.layers) { // Netscape 4
			document.hideShow.visibility = 'hidden';
		}
		else { // IE 4
			document.all.hideShow.style.visibility = 'hidden';
		}
	}
}

function showDiv() {
	if (document.getElementById) { // DOM3 = IE5, NS6
		document.getElementById('hideShow').style.visibility = 'visible';
	}
	else {
		if (document.layers) { // Netscape 4
			document.hideShow.visibility = 'visible';
		}
		else { // IE 4
			document.all.hideShow.style.visibility = 'visible';
		}
	}
}

function showHide(elem){
	// Quel est l'�tat actuel ?
	etat=document.getElementById(elem).style.visibility;
	if(etat=="hidden"){
		document.getElementById(elem).style.visibility="visible";
	}
	else{
		document.getElementById(elem).style.visibility="hidden";
	}
}