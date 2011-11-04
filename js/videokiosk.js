$(function(){
	$("#movie-highlight").bind("mouseover", highlight);
	$("#movie-highlight").bind("mouseleave", highlight);
	
});

function highlight(evt){
	$("#movie-highlight").toggleClass("highlighted");
}