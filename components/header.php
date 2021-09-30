<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' | '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php G::staticUrl('static/css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php G::staticUrl('static/css/G.css'); ?>">
    <style>
        html::before {
            <?php echo G::getBackground(); ?>
        }
    </style>
    <?php $this->header(); ?>
</head>
<body>

<header id="header">
    
</header>
