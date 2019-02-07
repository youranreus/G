<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php $this->archiveTitle(' &raquo; ', '', ' | '); ?><?php $this->options->title(); ?></title>

	<link rel="stylesheet" href="<?php $this->options->themeUrl('CSS/G.css'); ?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php $this->options->themeUrl('CSS/prism.css'); ?>" rel="stylesheet" />
	<style>
		html::before{
			  background: url(<?php $this->options->bkimg(); ?>) center 0 no-repeat;
		}
		<?php if ($this->options->enableOpac): ?>
		#zp,#links,#page,#post,#article,#comments{
		 opacity: 0.9;
	 	}
		<?php endif; ?>

	</style>

	<link rel="icon" type="image/png" href="/favicon.ico">
	<link href="/favicon.ico" rel="icon">
	<link rel='dns-prefetch' href='//s.w.org'>
	<link rel="apple-touch-icon-precomposed" href="/favicon.ico">
	<?php $this->header(); ?>


</head>

<body>
	<!-- 头部/pjax -->
	<div id="pjax-container">
		<div id="header">
			<div id="header-container">
				<h2><?php $this->options->title(); ?></h2>
				<div class="clear">
					<span><?php $this->options->description() ?></span>
					<nav>
						<a href="<?php Helper::options()->siteUrl()?>" <?php if ($this->is('index')) : ?> class="nav-focus"<?php endif; ?>>首页</a>
						<!--<a href="<?php Helper::options()->siteUrl()?>blog" <?php if ($this->is('archive') or $this->is('post')) : ?> class="nav-focus"<?php endif; ?>>文章</a>-->
						<a href="<?php Helper::options()->siteUrl()?>links.html" <?php if ($this->is('page','links')) : ?> class="nav-focus"<?php endif; ?>>友人帐</a>
						<a href="<?php Helper::options()->siteUrl()?>about.html" <?php if ($this->is('page','About')) : ?> class="nav-focus"<?php endif; ?>>关于</a>
					</nav>
				</div>
			</div>
		</div>

		<div id="M">
