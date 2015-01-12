var min=19; 

var max=40; 

function increaseFontSize() 

{   var p = document.getElementsByTagName('p1'); 

    for(i=0;i<p.length;i++) 

	   {   if(p[i].style.fontSize) 

	       { var s = parseInt(p[i].style.fontSize.replace("px","")); } 

	       else {   var s = 19; } 

		   if(s!=max) {   s += 1; } p[i].style.fontSize = s+"px" } } 

		   function decreaseFontSize() 

		   { var p = document.getElementsByTagName('p1'); 

		   for(i=0;i<p.length;i++) {   

		   if(p[i].style.fontSize) 

		   { var s = parseInt(p[i].style.fontSize.replace("px","")); } 

		   else { var s = 12; } 

		   if(s!=min) { s -= 1; } p[i].style.fontSize = s+"px" } }

