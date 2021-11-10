<?php if($this->options->articleStyle == 0): ?>
    <?php while($this->next()): ?>
        <div class="article-item">
            <h2 class="article-title"><a href="<?php $this->permalink(); ?>"><?php $this->title() ?></a></h2>
            <div class="article-data">
                <span><?php $this->category(); ?></span>
                <span><?php $this->date('Y-m-d'); ?></span>
            </div>
            <?php if(G::getArticleBanner($this) != 'none'): ?>
                <div class="article-banner-wrap"></div>
                <div style="background-image: url(<?php echo G::getArticleBanner($this); ?>);" class="article-banner"></div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

<?php if ($this->options->articleStyle == 1): ?>
    <?php while($this->next()): ?>
        <div class="article-item" style="width: 100%;">
            <h2 class="article-title"><a href="<?php $this->permalink(); ?>"><?php $this->title() ?></a></h2>
            <p><?php $this->excerpt(50); ?></p>
            <div class="article-data">
                <span><?php $this->category(); ?></span>
                <span><?php $this->date('Y-m-d'); ?></span>
            </div>
            <?php if(G::getArticleBanner($this) != 'none'): ?>
                <div class="article-banner-wrap"></div>
                <div style="background-image: url(<?php echo G::getArticleBanner($this); ?>);" class="article-banner"></div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

<?php if ($this->options->articleStyle == 2): ?>


<?php endif; ?>