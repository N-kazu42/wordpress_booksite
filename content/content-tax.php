<article class="article-card">
    <a href="<?php the_permalink(); ?>" class="card-link">
<div class="image">
<?php the_post_thumbnail(); ?>
</div>
<div class="body">
    <p class="title"><?php the_title(); ?></p>
    <time class="time"><?php the_time('Y/m/d'); ?></time>
    <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
    <div class="buttonBox">
        <button class="seeDetail" type="button">MORE</button>
    </div>
</div>
</a>
</article>