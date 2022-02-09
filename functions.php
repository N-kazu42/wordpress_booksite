<?php
function my_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('bundle_js', get_template_directory_uri() . '/assets/js/bundle.js', array());
    wp_enqueue_style('my_styles', get_template_directory_uri() . '/assets/css/styles.css', array());
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

// ヘッダー、フッターのカスタムメニュー化
register_nav_menus(
    array(
        'place_global' => 'グローバル',
        'place_footer' => 'フッターナビ'
    )
);

// メイン画像上にテンプレートごとの文字列を表示
function get_main_title()
{
    if (is_singular('post')) :
        $category_obj = get_the_category();
        return $category_obj[0]->name;
    elseif (is_page()) :
        return get_the_title();
    elseif (is_category() || is_tax()) :
        return single_cat_title();
    elseif (is_search()) :
        return 'サイト内検索結果';
    elseif (is_404()) :
        return 'ページが見つかりません';
    elseif (is_singular('daily_contribution')) :
        global $post;
        $term_obj = get_the_terms($post->ID, 'event');
        return $term_obj[0]->name;
    endif;
}
//子ページを取得する関数
function get_child_pages($number = -1, $specified_id = null)
{
    if (isset($specified_id)) :
        $parent_id = $specified_id;
    else :
        $parent_id = get_the_id();
    endif;
    $args = array(
        'posts_per_page'  => $number,
        'post_type'  => 'page',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'post_parent' => $parent_id,

    );
    $child_pages = new WP_Query($args);
    return $child_pages;
}
//アイキャッチ画像を利用できるようにする
add_theme_support('post-thumbnails');

//トップページのメイン画像用のサイズ設定
add_image_size('top', 1077, 622, true);

//地域貢献活動一覧画像用のサイズ設定
add_image_size('contribution', 557, 280, true);

//トップページの地域貢献活動にて使用している画像のサイズ設定
add_image_size('front-contribution', 255, 189, true);

//企業情報・店舗情報一覧画像用のサイズ設定
add_image_size('common', 465, 252, true);

//各ページのメイン画像用のサイズ設定
add_image_size('detail', 1100, 330, true);

//検索一覧画像用のサイズ設定
add_image_size('search', 168, 168, true);

//各テンプレートごとのメイン画像を表示  string '' (lengt
function get_main_image()
{
    if (is_page() || is_singular('daily_contribution')) :
        $attachment_id = get_field('main_image');
        if ($attachment_id) :
            return wp_get_attachment_image($attachment_id, 'detail');
        else :
            return get_the_post_thumbnail($post->ID, 'detail');
        endif;

    elseif (is_category('news') || is_singular('post')) :
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-news.jpg" />';
    elseif (is_search() || is_404()) :
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-search.jpg" />';
    elseif (is_tax('event')) :
        $term_obj = get_queried_object();
        $image_id = get_field('event_image', $term_obj->taxonomy . '_' . $term_obj->term_id);
        if($image_id):
        return wp_get_attachment_image($image_id, 'detail');
        else:
        return get_the_post_thumbnail($post->ID, 'detail');
        endif;
    else :
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-dummy.png" />';
    endif;
}
//特定の記事を抽出する関数
function get_specific_posts($post_type, $taxonomy = null, $term = null, $number = -1)
{
    if (!$term) :
        $terms_obj = get_terms($taxonomy);
        $term = wp_list_pluck($terms_obj, 'slug'); //上でカスタム投稿のObjectを取得し、下記でカスタム分類を表示させる

    endif;
    $args = array(
        'post_type' => $post_type, // (投稿: 'post')（固定ページ : 'page')
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy, // 'category'と入力するとデフォルトの投稿
                'field' => 'slug',
                'terms' => $term, // カテゴリーの中のスラッグに当たる
            ),
        ),
        'posts_per_page' => $number, // -1は全件
    );
    $specific_posts = new WP_Query($args);
    return $specific_posts;
}

//抜粋文の最後に付く文字列を変更
function cms_excerpt_more()
{
    return '...';
}
add_filter('excerpt_more', 'cms_excerpt_more');

//文字数を110文字から80文字に変更
function cms_excerpt_lenght()
{
    return 80;
}
add_filter('excerpt_mblength', 'cms_excerpt_lenght');

//抜粋機能を固定ページに使えるように設定
add_post_type_support('page', 'excerpt');

function get_flexible_excerpt($number)
{
    $value = get_the_excerpt();  //抜粋文を取得
    $value = wp_trim_words($value, $number, '...'); //抜粋文字、文字数、最後の文字
    return $value;
}

//get_th_excerpt()で取得する文字列に改行タグを挿入する
function apply_excerpt_br($value)
{
    return nl2br($value);
}
add_filter('get_the_excerpt', 'apply_excerpt_br');

//ウィジェット機能を有効化
function theme_widgets_init()
{
    register_sidebar(array(
        'name' => 'サイドバーウィジェットエリア', //ウィジェットエリアの名前
        'id' => 'primary-widget-area', //ウィジェットエリアのID
        'description' => '固定ページのサイドバー', //ウィジェットエリアの説明　管理画面で表示
        'before_widget' => '<aside class="side-inner">', //
        'after_widget' => '</aside>', //
        'before_title' => '<h4 class="title"', //
        'after_title' => '</h4>', //
    ));
}
add_action('widgets_init', 'theme_widgets_init');

//メイン画像上にテンプレートごとの英語タイトルを表記
function get_mail_en_title()
{
    
    if (is_category()) :// カテゴリアーカイブが表示されているかチェック
        $term_obj = get_queried_object();//現在クエリされているオブジェクトを取得
        $english_title = get_field('english_title', $term_obj->taxonomy . '_' . $term_obj->term_id);
        return $english_title;
    elseif (is_singular('post')) :// 通常の投稿を表示した時に true 
        $term_obj = get_the_category();//オブジェクト（カテゴリー）の配列を返します。各オブジェクトは現在の投稿が属するカテゴリーを表します
        $english_title = get_field('english_title', $term_obj[0]->taxonomy . '_' . $term_obj[0]->term_id);
        return $english_title;
    elseif (is_page() || is_singular('daily_contribution')) ://個別の固定ページを表示しているかどうかをチェック ｜｜　カスタム投稿のdaily_contributionかどうかチェック
        return get_field('english_title');
    elseif (is_search()) :
        return 'Search Result';
    elseif (is_404()) :
        return '404 Not Found';
    elseif (is_tax()) ://カスタム分類のアーカイブページが表示されているかどうかをチェック
        $term_obj = get_queried_object();
        $english_title = get_field('english_title', $term_obj->taxonomy . '_' . $term_obj->term_id);
        return $english_title;
    endif;
}
