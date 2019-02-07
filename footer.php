</div>
</div>
<div id="footer">
	<div id="footer-content" class="clear">
		<div id="footer-content-left">
			<p>©<?php $this->options->title(); ?></p>
			<p><?php $this->options->beian(); ?></p>
		</div>
		<div id="footer-content-right">
			<p><?php if ($this->options->enableUpyun): ?>
       <a href="https://upyun.com" target="_blank"><img src="https://i.loli.net/2019/02/07/5c5c38cd91876.png"/></a>
      <?php endif; ?>
			 <img src="https://i.loli.net/2019/02/07/5c5c38cd763ea.png"/></p>
		</div>
	</div>

	<script src="https://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
	<script type="text/javascript" src="<?php $this->options->themeUrl('JS/X.js'); ?>" ></script>
	<script type="text/javascript" src="<?php $this->options->themeUrl('JS/prism.js'); ?>"></script>
</div>
<a id="gototop"><img src="https://i.loli.net/2019/02/07/5c5c38f18079c.png"></a>
</body>
