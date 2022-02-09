<?php get_header(); ?>

<div class="page-inner">
    <div class="page-main" id="pg-contribution">
        <div class="contribution">
            <?php
            // taxonomy.phpなどのカスタム分類のテンプレートでは$termに閲覧しているタームのスラッグが自動的に格納
            $term = get_specific_posts('daily_contribution', 'event', $term, -1);
            if ($term->have_posts()) : while ($term->have_posts()) : $term->the_post();
                    get_template_part('content/content','tax');
                endwhile;
                wp_reset_postdata();
            endif;
            ?>

        </div>
    </div>
</div>
<?php get_footer(); ?>