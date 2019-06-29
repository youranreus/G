
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

var mobileHover = function () {
    $('*').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });
};

//pjax 刷新
$(document).pjax('a:not(a[target="_blank"], a[no-pjax])', {
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
	$("#post img").each(function(){
				$(this).wrap(function(){
					if($(this).is(".bq"))
					{
						 return '';
					}
				return '<a data-fancybox="gallery" no-pjax data-type="image" href="' + $(this).attr("src") + '" class="light-link"></a>';
		 })
	});
}).on('pjax:click',function() {
	var hash = window.location.hash;
	if(hash == "comments")
	{
		$("html,body").animate({scrollTop:$("#content").offset().top},200);
	}
	else
	{
		$('body,html').animate({scrollTop:0},200);
	}

}
);


Smilies = {
    dom: function(id) {
        return document.getElementById(id);
    },
    grin: function(tag) {
        tag = ' ' + tag + ' ';
        myField = this.dom("textarea");
        document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag);
    },
    insertTag: function(tag) {
        myField = Smilies.dom("textarea");
        myField.selectionStart || myField.selectionStart == "0" ? (startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = startPos, myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length), cursorPos += tag.length, myField.focus(), myField.selectionStart = cursorPos, myField.selectionEnd = cursorPos) : (myField.value += tag, myField.focus());
    }
}


function OwO_show(){
	if($("#OwO-container").css("display")=='none'){
		 $("#OwO-container").slideDown();
	}else{
		 $("#OwO-container").slideUp();
	 }
}


console.info(
  " %c made with ❤ by youranreus ",
  'color: #fadfa3; background: #030307; padding:5px 0;'
)
