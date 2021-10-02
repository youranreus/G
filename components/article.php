<?php while($this->next()): ?>
    <div class="article-item">
        <h2 class="article-title"><a href="<?php $this->permalink(); ?>"><?php $this->title() ?></a></h2>
        <div class="article-data">
            <span><?php $this->category(); ?></span>
            <span><?php $this->date('Y-m-d'); ?></span>
        </div>
    </div>
<?php endwhile; ?>