$(document).ready(function(){
				
	$(window).scroll(function(){
		var scroTop = $(window).scrollTop();
		if(scroTop>100){
			$('#gototop').fadeIn(500);
		}else{
			$('#gototop').fadeOut(500);
		}
	});
		    	
	$('#gototop').click(function(){
		$("html,body").animate({scrollTop:0},"fast");
	});
	
});
$(document).pjax('a[target!=_blank]', {
	container: '#pjax-container',
	fragment: '#pjax-container',
	timeout: 8000
}).on('pjax:send',
function() {
	$("#M").addClass("opacity-disappear");
}).on('pjax:complete',
function() {
	if (typeof Prism !== 'undefined') {
		Prism.highlightAll(true,null);
	}
	$("#M").addClass("opacity-show");
}).on('pjax:click',function() {$('body,html').animate({scrollTop:0},200);});

console.info(
  " %c made by youranreus with love %c https://exia.xyz",
  'color: #fadfa3; background: #030307; padding:5px 0;',
  'background: #fadfa3;padding:5px 5px 5px 0;'
)