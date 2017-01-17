/**
 * The nav stuff
 */
var body = document.body,
mask = document.createElement("div"),
toggleSlideLeft = document.querySelector( ".toggle-slide-left" ),
toggleSlideTop = document.querySelector( ".toggle-slide-top" ),
slideMenuLeft = document.querySelector( ".slide-menu-left" ),
slideMenuTop = document.querySelector( ".slide-menu-top" ),
activeNav
;
mask.className = "mask"; 
 
function toggleTop()
{
    classie.add( body, "smt-open" );
    document.body.appendChild(mask);
    activeNav = "smt-open";
    document.getElementById("BLACKOUT").style.display = "block";
}
 
(function( window ){
	
	'use strict';

	/* slide menu left */
	toggleSlideLeft.addEventListener( "click", function(){
		classie.add( body, "sml-open" );
		document.body.appendChild(mask);
		activeNav = "sml-open";
        document.getElementById("BLACKOUT").style.display = "block";
	} );

	/* hide active menu if mask is clicked */
	mask.addEventListener( "click", function(){
		classie.remove( body, activeNav );
		activeNav = "";
		document.body.removeChild(mask);
        document.getElementById("BLACKOUT").style.display = "none";
	} );

	/* hide active menu if close menu button is clicked */
	[].slice.call(document.querySelectorAll(".slide-menu-left")).forEach(function(el,i){
		el.addEventListener( "click", function(){
            classie.remove( body, activeNav );
            activeNav = "";
            document.body.removeChild(mask);
            document.getElementById("BLACKOUT").style.display = "none";                         
		} );
	});
})( window );

function THNK(){triggerthink(1);}
document.querySelector(".MBTNS").addEventListener("click", THNK, false); 
