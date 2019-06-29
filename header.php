<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<!-- DNS预解析 -->
	<link rel="dns-prefetch" href="//cdn.bootcss.com">
	<link rel="dns-prefetch" href="//i.loli.net">

	<title><?php $this->archiveTitle(' &raquo; ', '', ' | '); ?><?php $this->options->title(); ?></title>

	<link rel="stylesheet" href="<?php $this->options->themeUrl('CSS/G.css'); ?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php $this->options->themeUrl('CSS/shortcode.G.css'); ?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php $this->options->themeUrl('CSS/OwO.min.css'); ?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php $this->options->themeUrl('CSS/prism.css'); ?>" rel="stylesheet" />
	<link href="https://cdn.bootcss.com/fancybox/3.5.6/jquery.fancybox.min.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
	<style>

		<?php if ($this->options->enableOneRow == 0): ?>
		.article-item {
	    background: white;
	    border-radius: 30px;
	    box-shadow: 0px 0px 70px 6px rgba(0,0,0,0.12);
	    padding: 30px;
	    margin: 20px 0;
		}
		.article-item h2{
	    margin-bottom: 20px;
		}
		@media screen and (max-width: 768px) {

			.article-item {
		    background: white;
		    border-radius: 30px;
		    box-shadow: 0px 0px 70px 6px rgba(0,0,0,0.12);
		    padding: 20px;
		    width: 87%;
		    margin: 20px auto;
		    float: none;
			}

		}
		@media screen and (max-width: 1024px) {

			.article-item {
		    background: white;
		    border-radius: 30px;
		    box-shadow: 0px 0px 70px 6px rgba(0,0,0,0.12);
		    padding: 20px;
		    width: 90%;
		    margin: 20px auto;
		    float: none;
			}

		}
		<?php else: ?>
		.article-item {
	    background: white;
	    border-radius: 30px;
	    box-shadow: 0px 0px 70px 6px rgba(0,0,0,0.12);
	    padding: 30px;
	    width: 320px;
	    margin: 10px;
	    float: left;
		}
		@media screen and (max-width: 768px) {

			.article-item {
		    background: white;
		    border-radius: 30px;
		    box-shadow: 0px 0px 70px 6px rgba(0,0,0,0.12);
		    padding: 20px;
		    width: 87%;
		    margin: 20px auto;
		    float: none;
			}

		}


		<?php endif; ?>
		html{
			background-color: <?php $this->options->bkcolor(); ?>;
		}
		html::before{
			  background-image: url(<?php $this->options->bkimg(); ?>);
		}


		<?php if ($this->options->enableOpac): ?>
		#zp,#links,#page,#post,#article,#comments{
		 opacity: 0.9;
	 	}
		<?php endif; ?>

		<?php if ($this->options->animateTime): ?>

		.opacity-show {
			animation: opacity-show <?php $this->options->animateTime(); ?>;
			-moz-animation: opacity-show <?php $this->options->animateTime(); ?>;
			/* Firefox*/
			-webkit-animation: opacity-show <?php $this->options->animateTime(); ?>;
			/* Safari and Chrome*/
			-o-animation: opacity-show <?php $this->options->animateTime(); ?>;
			/* Opera*/
		}
		.opacity-disappear {
			animation: opacity-disappear <?php $this->options->animateTime(); ?>;
			-moz-animation: opacity-disappear <?php $this->options->animateTime(); ?>;
			/* Firefox*/
			-webkit-animation: opacity-disappear <?php $this->options->animateTime(); ?>;
			/* Safari and Chrome*/
			-o-animation: opacity-disappear <?php $this->options->animateTime(); ?>;
			/* Opera*/
		}
		<?php else: ?>
		.opacity-show {
			animation: opacity-show 1s;
			-moz-animation: opacity-show 1s;
			/* Firefox*/
			-webkit-animation: opacity-show 1s;
			/* Safari and Chrome*/
			-o-animation: opacity-show 1s;
			/* Opera*/
		}
		.opacity-disappear {
			animation: opacity-disappear 1s;
			-moz-animation: opacity-disappear 1s;
			/* Firefox*/
			-webkit-animation: opacity-disappear 1s;
			/* Safari and Chrome*/
			-o-animation: opacity-disappear 1s;
			/* Opera*/
		}
		<?php endif; ?>

	</style>

	<link rel="icon" type="image/png" href="<?php $this->options->favicon(); ?>">
	<link href="<?php $this->options->favicon(); ?>" rel="icon">
	<link rel='dns-prefetch' href='//s.w.org'>
	<link rel="apple-touch-icon-precomposed" href="<?php $this->options->favicon(); ?>">
	<?php $this->header(); ?>


</head>

<body ontouchstart>
	<!-- 头部/pjax -->
	<div id="pjax-container">
		<div id="header">
			<div id="header-container">
				<h2><?php $this->options->title(); ?></h2>
				<div class="clear">
					<span><?php $this->options->description() ?></span>
					<nav>
						<a href="<?php Helper::options()->siteUrl()?>" <?php if ($this->is('index')) : ?> class="nav-focus"<?php endif; ?>>首页</a>
						<?php if ($this->options->enableIndexPage): ?>
								<a href="<?php Helper::options()->siteUrl()?>blog" <?php if ($this->is('archive') or $this->is('post')) : ?> class="nav-focus"<?php endif; ?>>文章</a>
      			<?php endif; ?>
						<a href="<?php Helper::options()->siteUrl()?>links.html" <?php if ($this->is('page','links')) : ?> class="nav-focus"<?php endif; ?>>友人帐</a>
						<a href="<?php Helper::options()->siteUrl()?>about.html" <?php if ($this->is('page','About')) : ?> class="nav-focus"<?php endif; ?>>关于</a>
					</nav>
				</div>
			</div>
		</div>

		<div id="M">
