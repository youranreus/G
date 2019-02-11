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
	<script type="text/javascript" src="<?php $this->options->themeUrl('JS/prism.js'); ?>"></script>
	<script src="https://cdn.bootcss.com/fancybox/3.5.6/jquery.fancybox.min.js"></script>
	<script>
		$(document).ready(function(){
				$("#post img").each(function(){
						$(this).wrap(function(){
							if($(this).is(".bq"))
							{
								 return '';
							}
						return '<a data-fancybox="gallery" no-pjax data-type="image" href="' + $(this).attr("src") + '" class="light-link"></a>';
				 })
			})
		})
 </script>
</div>
<a id="gototop"><img src="https://i.loli.net/2019/02/11/5c617e353eb56.png"></a>
</body>
