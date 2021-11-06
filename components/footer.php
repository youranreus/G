<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

    <footer>
        <div id="footer-content">
            <div id="footer-sponsor">
                <?php echo G::getFooterLogos(); ?>
            </div>
            <nav id="footer-nav">
				<a href="<?php Helper::options()->siteUrl()?>" <?php if ($this->is('index')) : ?> class="nav-focus"<?php endif; ?>>首页</a>
				<?php if ($this->options->enableIndexPage): ?>
						<a href="<?php echo G::getArticlePath(); ?>" <?php if ($this->is('archive') or $this->is('post')) : ?> class="nav-focus"<?php endif; ?>>文章</a>
				<?php endif; ?>
				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while($pages->next()): ?>
                    <a href="<?php $pages->permalink(); ?>" <?php if ($this->is('page', $pages->slug)): ?>class="nav-focus"<?php endif; ?> title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                <?php endwhile; ?>
			</nav>
        </div>
        <p id="footer-meta" class="clear">
            <span class="left"><a class="icp" href="http://beian.miit.gov.cn"><?php echo G::getICP(); ?></a></span>
            <span class="right"><?php echo $this->options->buildYear." - ".date('Y'); ?> &copy <?php $this->options->title(); ?></span>
        </p>
    </footer>
</div>
<?php $this->footer(); ?>
<script src="<?php echo G::staticUrl('static/js/lib.js'); ?>?v=3.10012"></script>
<script src="<?php echo G::staticUrl('static/js/prism.js'); ?>?v=1.01" data-manual></script>
<script src="<?php echo G::staticUrl('static/js/G.js'); ?>?v=3.10019"></script>
</body>
</html>
