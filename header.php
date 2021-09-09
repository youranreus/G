<!DOCTYPE html>
<html lang="zh">
<head>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <!-- DNS预解析 -->
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">

    <title><?php $this->archiveTitle(' &raquo; ', '', ' | '); ?><?php $this->options->title(); ?></title>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.1.1/dist/jquery.min.js"></script>
    <link href="<?php $this->options->themeUrl('CSS/G.css'); ?>?v=2.4.72" rel="stylesheet"/>
    <link href="<?php $this->options->themeUrl('CSS/message.css'); ?>" rel="stylesheet"/>
    <link href="<?php $this->options->themeUrl('CSS/shortcode.G.css'); ?>?v=2.3.99" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/gh/youranreus/G/CSS/OwO.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/gh/youranreus/G/CSS/prism.css" rel="stylesheet"/>
    <?php if ($this->options->enablenprogress == 1): ?>
        <link href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css" rel="stylesheet"/>
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/youranreus/G/JS/DPlayer.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.13.11/dist/katex.min.css"
          integrity="sha384-Um5gpz1odJg5Z4HAmzPtgZKdTBHZdw8S29IecapCSB31ligYPhHQZMIlWLYQGVoc" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.11/dist/katex.min.js"
            integrity="sha384-YNHdsYkH6gMx9y3mRkmcJ2mFUjTd0qNQQvY9VYZgQd7DcN7env35GzlmFaZ23JGp"
            crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.11/dist/contrib/auto-render.min.js"
            integrity="sha384-vZTG03m+2yp6N6BNi5iM4rW4oIwk5DfcNdFfxkk9ZWpDriOkXX8voJBFrAO7MpVl"
            crossorigin="anonymous"></script>


    <script>
        window.QMSG_GLOBALS = {
            DEFAULTS: {
                showClose: false,
                timeout: 1000,
                html: false
            }
        }
    </script>
    <style>
        <?php if ($this->options->IndexStyle == 1): ?>
        .article-item {
            background: white;
            border-radius: 30px;
            box-shadow: 0 0 70px 6px rgba(0, 0, 0, 0.12);
            padding: 30px;
            margin: 20px 0;
        }

        .article-item h2 {
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {

            .article-item {
                background: white;
                border-radius: 30px;
                box-shadow: 0 0 70px 6px rgba(0, 0, 0, 0.12);
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
                box-shadow: 0 0 70px 6px rgba(0, 0, 0, 0.12);
                padding: 20px;
                width: 90%;
                margin: 20px auto;
                float: none;
            }

        }

        <?php elseif ($this->options->IndexStyle == 0): ?>
        .article-item {
            background: white;
            border-radius: 30px;
            box-shadow: 0 0 70px 6px rgba(0, 0, 0, 0.12);
            width: 45%;
            margin: 2.5%;
            float: left;
        }

        .article-item-content {
            margin: 30px;
        }

        @media screen and (max-width: 768px) {

            .article-item {
                background: white;
                border-radius: 30px;
                box-shadow: 0 0 70px 6px rgba(0, 0, 0, 0.12);
                width: 100%;
                padding: 1px;
                margin: 20px auto;
                float: none;
            }

            .article-item-content {
                margin: 20px;
            }

        }

        <?php endif; ?>

        html {
            background-color: <?php $this->options->bkcolor(); ?>;
        }

        html::before {
            background-image: url(<?php $this->options->bkimg(); ?>);
        }


        <?php if ($this->options->enableOpac): ?>
        #zp, #links, #page, #post, #article, #comments, #post-related-posts {
            opacity: 0.9;
        }

        <?php endif; ?>


        <?php if ($this->options->animateTime): ?>

        .opacity-show {
            animation: opacity-show  <?php $this->options->animateTime(); ?>;
            -moz-animation: opacity-show  <?php $this->options->animateTime(); ?>;
            /* Firefox*/
            -webkit-animation: opacity-show  <?php $this->options->animateTime(); ?>;
            /* Safari and Chrome*/
            -o-animation: opacity-show  <?php $this->options->animateTime(); ?>;
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

        <?php if ($this->options->headerbkcolor): ?>
        #header, #footer {
            background: <?php echo $this->options->headerbkcolor; ?>
        }

        <?php endif; ?>

        <?php if (!$this->options->enableSliderBarPhoto): ?>
        #sliderbar-photo {
            display: none;
        }

        #categoryList {
            width: 100%;
        }

        <?php endif; ?>

        #post-content-article h1, #post-content-article h2, #post-content-article h3, #post-content-article h4 {
            color: RGB(48, 71, 88);
        }

        <?php echo $this->options->CustomCSS;?>
    </style>
    <script>
        <?php echo $this->options->CustomJSh;?>
    </script>
    <link href="<?php $this->options->themeUrl('CSS/dark.css'); ?>?v=2.4.6.1" rel="<?php if (!isset($_COOKIE['night']) || $_COOKIE['night'] != '1') {
        echo 'alternate ';
      } ?>stylesheet" type="text/css" title="dark">
    <link rel="icon" type="image/png" href="<?php $this->options->favicon(); ?>">
    <link href="<?php $this->options->favicon(); ?>" rel="icon">
    <link rel='dns-prefetch' href='//s.w.org'>
    <link rel="apple-touch-icon-precomposed" href="<?php $this->options->favicon(); ?>">
    <?php $this->header(); ?>
</head>

<body>
<!-- 头部/pjax -->
<div id="pjax-container">
    <div id="header">
        <?php if ($this->options->headerLOGO): ?>
            <img id="header-logo" src="<?php echo $this->options->headerLOGO; ?>" alt="header-logo"/>
        <?php endif; ?>
        <div id="header-container">
            <h2><?php $this->options->title(); ?></h2>
            <div class="clear">
                <span><?php $this->options->description() ?></span>
                <nav>
                    <a href="<?php Helper::options()->siteUrl() ?>" <?php if ($this->is('index')) : ?> class="nav-focus"<?php endif; ?>>首页</a>
                    <?php if ($this->options->enableIndexPage): ?>
                        <a href="<?php Helper::options()->siteUrl() ?><?php if ($this->options->articlePath != '') {
                            echo $this->options->articlePath;
                        } else {
                            echo 'index.php/blog';
                        } ?>" <?php if ($this->is('archive') or $this->is('post')) : ?> class="nav-focus"<?php endif; ?>>文章</a>
                    <?php endif; ?>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while ($pages->next()): ?>
                        <?php if ($pages->slug == 'links' or strtolower($pages->slug) == 'about' or $pages->fields->showHeader == 1): ?>
                            <a class="<?php if ($this->is('page', $pages->slug)): ?> nav-focus<?php endif; ?>"
                               href="<?php $pages->permalink(); ?>"
                               title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                        <?php endif; ?>
                    <?php endwhile; ?>
                    <?php if ($this->options->enableHeaderSearch == 1): ?>
                        <a style=" cursor: pointer;" class="search-form-input">搜索</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>

    <div id="M">
