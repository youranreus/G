</div>
</div>
<div id="footer">
	<div id="footer-content" class="clear">
		<div id="footer-content-left">
			<p id="footer-time">©<?php $this->options->title(); ?> | <span id="site_runtime"></span></p>
			<p><a href="http://beian.miit.gov.cn/"><?php $this->options->beian(); ?></a></p>
			<nav id="nav-2">
				<a href="<?php Helper::options()->siteUrl()?>">首页</a>
				<?php if ($this->options->enableIndexPage): ?>
						<a href="<?php Helper::options()->siteUrl()?><?php if($this->options->articlePath != ''){echo $this->options->articlePath;}else{echo 'index/blog';} ?>" <?php if ($this->is('archive') or $this->is('post')) : ?> class="nav-focus"<?php endif; ?>>文章</a>
				<?php endif; ?>
				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
        <?php while($pages->next()): ?>
        <a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
        <?php endwhile; ?>
				<?php if (isset($this->options->plugins['activated']['ExSearch'])) : ?>
				<a class="search-form-input">搜索</a>
				<?php endif ?>
			</nav>
		</div>
		<div id="footer-content-right">
			<p>
				<?php if ($this->options->enableUpyun): ?>
       		<a href="https://www.upyun.com/?utm_source=lianmeng&utm_medium=referral" target="_blank"><img src="<?php $this->options->themeUrl('IMG/upyun.png'); ?>"/></a>
      	<?php endif; ?>
				<?php if ($this->options->enableAliLogo): ?>
	       <img src="<?php $this->options->themeUrl('IMG/aliyun.svg'); ?>"/>
	      <?php endif; ?>
			</p>
		</div>
	</div>

	<script>
		<?php if($this->options->enableLazyload == 1): ?>
			const enableLazyload = true;
		<?php else: ?>
			const enableLazyload = false;
		<?php endif; ?>
	</script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-pjax@2.0.1/jquery.pjax.min.js"></script>
	<script src="<?php $this->options->themeUrl('JS/lazyload.min.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('JS/message.min.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('JS/tipped.min.js'); ?>"></script>
 	<script src="<?php $this->options->themeUrl('JS/X.js'); ?>?v=2.4.9.2"></script>
	<!-- <script src="<?php $this->options->themeUrl('JS/X.js'); ?>?v=2.4.6.4<?php echo rand(0,1000); ?>"></script> -->
	<script src="<?php $this->options->themeUrl('JS/prism.js'); ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/tocbot@4.12.0/dist/tocbot.min.js"></script>
	<?php if ($this->options->enablenprogress == 1): ?>
			<script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.min.js"></script>
	<?php endif; ?>
	<?php if ($this->options->enableSmooth): ?>
		<script src="https://cdn.jsdelivr.net/gh/gblazex/smoothscroll-for-websites@1.4.10/SmoothScroll.js"></script>
		<script>
		SmoothScroll({ stepSize: 40 })
		</script>
	<?php endif; ?>



	<?php $this->footer(); ?>



</div>

<div id="footer-toolbar">
	<?php if (isset($this->options->plugins['activated']['ExSearch'])) : ?>
		<div id="m_search">
			<span><a><i class="i m_search search-form-input"></i></a></span>
		</div>
	<?php endif ?>

	<div id="m_toc"  onclick="toc_toggle();">
		<span><a><i class="i m_toc"></i></a></span>
	</div>

	<div id="m_top" onclick="gototop();">
		<span><a><i class="i gototop"></i></a></span>
	</div>

	<div id="m_menu" onclick="sideMenu_toggle();">
		<span><a><i class="i m_menu"></i></a></span>
	</div>

	<div id="m_night" onclick="switchNightMode();">
		<span><a><i class="i m_night"></i></a></span>
	</div>
</div>


<?php  $this->need('sliderbar.php'); ?>
<script>
	ajaxc();
	PreFancybox();
	imageinfo();
	generateTiptools();
	toc();
	makeGallery();
	collapse_toggle();
	agree();
	autoNight();
	jQuery(document).ready(function ($) {
			$(".lazyload").lazyload({
						threshold: 100,
						effect: "fadeIn"
			});
	});
	show_site_runtime("<?php getBuildTime($this->options->builtTime);?>");
	<?php echo $this->options->CustomJSf;?>
	$("#sliderbar-photo").height($('#categoryList').height());
	if(document.getElementById("sliderbar-video")!=undefined)
	{
		if($("#sliderbar-photo").height() >= $("#sliderbar-photo").width())
		{
			$("#sliderbar-video").height($('#sliderbar-photo').height());
		}
		else
		{
			$("#sliderbar-video").height($('#sliderbar-photo').width());
		}
	}

	window.onload = function(){
		if(document.getElementById('post-content-article')!=undefined)
	  {
	    renderMathInElement(document.getElementById('post-content-article'), {
	      delimiters: [
	          {left: '$$', right: '$$', display: true},
	          {left: '$', right: '$', display: false}
	      ],
	      throwOnError : true
	    });
	  }
	}


</script>
</body>
