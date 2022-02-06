<?php get_header(); ?>

<!-- ショップ一覧 ーーーーーーーーーーーーーー-->
<section class="section-contents" id="shop">
  <div class="wrapper">

    <?php
    $shop_obj = get_page_by_path('shop');
    $post = $shop_obj;
    setup_postdata($post);
    $shop_title = get_the_title();
    ?>

    <span class="section-title-en">Shop Information</span>
    <h2 class="section-title"><?php the_title(); ?></h2>
    <p class="section-lead"><?php echo get_the_excerpt(); ?></p>
    <?php wp_reset_postdata(); ?>
    <ul class="shops">
      <?php
      $shop_pages = get_child_pages( 4, $shop_obj->ID);
      if ($shop_pages->have_posts()) :
        while ($shop_pages->have_posts()) : $shop_pages->the_post();
      ?>
          <li class="shops-item">
            <a class="shop-link" href="<?php the_permalink(); ?>">
              <div class="shop-image">
                <?php the_post_thumbnail('common'); ?>"
              </div>
              <div class="shop-body">
                <p class="name"><?php the_title(); ?></p>
                <p class="location"></p>
                <div class="buttonBox">
                  <button type="button" class="seeDetail">MORE</button>
                </div>
              </div>
            </a>
          </li>
      <?php endwhile;
        wp_reset_postdata();
      endif; ?>
    </ul>
    <div class="section-buttons">
      <button type="button" class="button button-ghost" onclick="javascript:location.href = '<?php echo esc_url( home_url('shop') ); ?>';"><?php echo $shop_title; ?>一覧を見る
      </button>
    </div>
  </div>
</section>

<!-- 地域貢献活動を見る ーーーーーーーーーーーーーーーー-->
<section class="section-contents" id="contribution">
  <div class="wrapper">
    <?php
    $contribution_obj = get_page_by_path('contribution');  //固定ページのスラッグからオブジェクトを取得
    $post = $contribution_obj; //それを$POSTに返して、その後使いまわせるようにする
    setup_postdata($post); //$postをグローバルで使えるようにする
    $contribution_title = get_the_title(); //あとでタイトルが必要なので取得しておく
    ?>
    <span class="section-title-en">Regional Contribution</span>
    <h2 class="section-title"><?php the_title(); ?></h2>
    <p class="section-lead">><?php echo get_the_excerpt(); ?></p>
     <?php wp_reset_postdata(); ?> <!--サブクエリを実行した後に、メインクエリに戻すときに記述する -->

    <div class="articles">

    <?php
      $contribution_pages = get_child_pages( 3, $contribution_obj->ID); //変数からidを取得して子ページを表示していく
      if ($contribution_pages->have_posts()) : //子ページの固定ページがあるか判断
        while ($contribution_pages->have_posts()) : $contribution_pages->the_post();
      ?>
      <article class="article-card">
        <a class="card-link" href="<?php the_permalink(); ?>"><!--子ページのリンクを出力 -->
          <div class="card-inner">
            <div class="card-image">
            <?php the_post_thumbnail('front-contribution'); ?>"<!--設定しているサムネイルの大きさで出力 -->
            </div>
            <div class="card-body">
              <p class="title"><?php the_title(); ?></p><!--タイトル -->
              <p class="excerpt"><?php echo get_the_excerpt(); ?></p>　<!--記事 -->
              <div class="buttonBox">
                <button type="button" class="seeDetail">MORE</button>
              </div>
            </div>
          </div>
        </a>
      </article>
      <?php endwhile;
        wp_reset_postdata();
      endif; ?>
    </div>
    <div class="section-buttons">
      <button type="button" class="button button-ghost" onclick="javascript:location.href = '<?php echo esc_url( home_url('contribution') ); ?>';"><?php echo $contribution_title; ?>を見る
      </button>
    </div>
  </div>
</section>

<!-- news一覧ーーーーーーーーーーーーー -->
<section class="section-contents" id="news">
  <div class="wrapper">
    <?php $term_obj = get_term_by('slug','news','category')?>
    <span class="section-title-en">News Release</span>
    <h2 class="section-title"><?php echo $term_obj->name; ?></h2>
    <p class="section-lead"><?php echo $term_obj->description; ?></p>
    <ul class="news">

    <?php
    $news_posts = get_specific_posts('post','category','news',3);
    if($news_posts->have_posts()):
      while($news_posts->have_posts()) : $news_posts->the_post();
    ?>

      <li class="news-item">
        <a class="detail-link" href="<?php the_permalink(); ?>">
          <time class="time"><?php the_time('Y/m/d'); ?></time>
          <p class="title"><?php the_title(); ?></p>
          <p class="news-text"><?php echo get_the_excerpt(); ?></p>
        </a>
      </li>

      <?php endwhile;
        wp_reset_postdata();
      endif; ?>
      
    </ul>
    <div class="section-buttons">
      
      <button type="button" class="button button-ghost" onclick="javascript:location.href = '#';">
        ニュースリリース一覧を見る
      </button>
    </div>
  </div>
</section>
<section class="section-contents" id="company">
  <div class="wrapper">
    <span class="section-title-en">Enterprise Information</span>
    <h2 class="section-title">企業情報</h2>
    <p class="section-lead">
      私たちパシフィックモール開発は、<br />
      ショッピングモール開発を通じて新たな価値を創造し<br />
      社会に貢献するグローバルな企業を目指します。
    </p>
    <div class="section-buttons">
      <button type="button" class="button button-ghost" onclick="javascript:location.href = '#';">
        企業情報を見る
      </button>
    </div>
  </div>
</section>
<?php get_footer(); ?>