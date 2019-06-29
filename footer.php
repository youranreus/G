</div>
</div>
<div id="footer">
	<div id="footer-content" class="clear">
		<div id="footer-content-left">
			<p>©<?php $this->options->title(); ?> | <?php getBuildTime($this->options->builtTime); ?></p>
			<p><?php $this->options->beian(); ?></p>
		</div>
		<div id="footer-content-right">
			<p><?php if ($this->options->enableUpyun): ?>
       <a href="https://upyun.com" target="_blank"><img src="https://i.loli.net/2019/02/11/5c6187c809c8c.png"/></a>
      <?php endif; ?>
			 <img src="https://i.loli.net/2019/02/11/5c6187e663b3a.png"/></p>
		</div>
	</div>

	<script src="https://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
 	<script src="<?php $this->options->themeUrl('JS/X.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('JS/prism.js'); ?>"></script>
	<script src="https://cdn.bootcss.com/fancybox/3.5.6/jquery.fancybox.min.js"></script>
	<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
	<script>
		$(document).ready(
			function(){
				$("#post img").each(function(){
						$(this).wrap(function(){
							if($(this).is(".bq"))
							{
								 return '';
							}
						return '<a data-fancybox="gallery" no-pjax data-type="image" href="' + $(this).attr("src") + '" class="light-link"></a>';
				 })
			})
		});
	</script>

	<script>

	//感谢https://eriri.ink/archives/typecho-ajaxcomment.html
	function ajaxc(){
			var replyTo = '',   //回复评论时候的ID
			submitButton = $(".submit").eq(0),  //提交评论按钮
			commentForm = $("#comment-form"),   //评论表单
			newCommentId = "";   //新评论的ID
			var bindButton = function () {
        $(".comment-reply a").click(function () {
            replyTo = $(this).parent().parent().parent().attr("id");
            console.log(replyTo);
        });
        $(".cancel-comment-reply a").click(function () { replyTo = ''; });
    };
			bindButton();

			/**
			 * 发送前的处理
			 */
			function beforeSendComment() {
				toastr.info('发射中..');
			}

			/**
			 * 发送后的处理
			 * @param {boolean} ok
			 */
			function afterSendComment(ok) {
					if (ok) {
							$("#textarea").val('');
							replyTo = '';
					}
					bindButton();
			}
			$("#comment-form").submit(function () {
					commentData = $(this).serializeArray();
					beforeSendComment();
					$.ajax({
							type: $(this).attr('method'),
							url: $(this).attr('action'),
							data: commentData,
							error: function (e) {
									console.log('Ajax Comment Error');
									window.location.reload();
							},
							success: function (data) {
									if (!$('#comments', data).length) {
											var msg = $('title').eq(0).text().trim().toLowerCase() === 'error' ? $('.container', data).eq(0).text() : '评论提交失败！';
											toastr.info(msg);
											afterSendComment(false);
											return false;
									}

									$("input,textarea", commentForm).attr('disabled', false);
									$("#textarea").val('');

									var newComment;
									newCommentId = $(".comment-list", data).html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function (a, b) { return a - b }).pop();
									if('' === replyTo) {
											if(!$('.comment-list').length) {
													newComment  = $("#li-comment-" + newCommentId, data);
													$('.comments-header').after('<ol class="comment-list"></ol>');
													$('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
											}
											else if($('.prev').length) {
													$('#page-nav ul li a').eq(1).click();
											}
											else {
													newComment  = $("#li-comment-" + newCommentId, data);
													$('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
											}
											$('html,body').animate({scrollTop:$('#response').offset().top - 100},1000);
									}
									else {
											newComment = $("#li-comment-" + newCommentId, data);
											if ($('#' + replyTo).find('.comment-children').length) {
													$('#' + replyTo + ' .comment-children .comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
													TypechoComment.cancelReply();
											}
											else {
													$('#' + replyTo).append('<div class="comment-children"><ol class="comment-list"></ol></div>');
													$('#' + replyTo + ' .comment-children .comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
													TypechoComment.cancelReply();
											}
									}
									afterSendComment(true);
									toastr.success('评论成功');

							}
					});
					return false;
			});
}
ajaxc();
$(document).on('pjax:complete', function() {
	ajaxc();
})
	</script>
</div>
<a id="gototop"><img src="https://i.loli.net/2019/02/11/5c617e353eb56.png"></a>
</body>
