<?php /*

  This file is part of a child theme called Roofresto.
  Functions in this file will be loaded before the parent theme's functions.
  For more information, please read
  https://developer.wordpress.org/themes/advanced-topics/child-themes/

*/

// this code loads the parent's stylesheet (leave it in place unless you know what you're doing)

function roofresto_theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, 
      get_template_directory_uri() . '/style.css'); 

    wp_enqueue_style( 'child-style', 
      get_stylesheet_directory_uri() . '/style.css', 
      array($parent_style), 
      wp_get_theme()->get('Version') 
    );

  //Style
  wp_enqueue_style( 'style-guide', get_stylesheet_directory_uri().'/css/style-guide.css',array(), '1.0.0');
  wp_enqueue_style( 'style-theme', get_stylesheet_directory_uri().'/css/style-theme.css',array(), '1.0.0');
  wp_enqueue_style( 'style-home', get_stylesheet_directory_uri().'/css/style-home.css',array(), '1.0.0');
  wp_enqueue_style( 'style-contact', get_stylesheet_directory_uri().'/css/contact-page.css',array(), '1.0.0');
  wp_enqueue_style( 'style-services', get_stylesheet_directory_uri().'/css/style-services.css',array(), '1.0.0');

  // Js
  wp_enqueue_script( 'theme-main', get_stylesheet_directory_uri() .'/js/theme-main.js',  array('jquery'), '1.0.0', true );
}

add_action('wp_enqueue_scripts', 'roofresto_theme_enqueue_styles', 9999);

require get_stylesheet_directory() . '/inc/elementor-widgets.php';
require get_stylesheet_directory() . '/inc/functions-themes.php';

// filter Blog navigation
add_action('wp_ajax_pageBlogNavi', 'pageBlogNavi');
add_action('wp_ajax_nopriv_pageBlogNavi', 'pageBlogNavi');
function pageBlogNavi() {
  global $post;
  $cat = null;
  if (isset($_POST['show'])) {
    $cat = $_POST['show'];
  }
  $number_product = null;
  if (isset($_POST['number_product'])) {
    $number_product = $_POST['number_product'];
  }
  $paged = 1;
  $posts_per_page = $number_product;
  if (isset($_POST['load']) && isset($_POST['show'])) {
    $paged = $_POST['load'];
    $cat = $_POST['show'];
  }
  $args = array(
    'paged' => $paged,
    'posts_per_page' => $posts_per_page,
    'post_type' => 'post',
    'category_name' => $cat
  );

  $loop = new WP_Query($args);
  $number_of_page = $loop->max_num_pages;
  $html = '';
  while ($loop->have_posts()) : $loop->the_post();
    $title = get_the_title();
    $get_terms = get_the_terms( get_the_ID(), 'category' );
    $the_post_thumbnail = get_the_post_thumbnail();
    $the_permalink = get_the_permalink();
    $date = get_the_date('j M Y');
    $html .= '<div class="post-item">';
    $html .= '<div class="wrap-item">';
    $html .= '<div class="thumbnail">';
    $html .= '<div class="wrap-thumbnail"><a href="'.$the_permalink.'">';
    $html .= $the_post_thumbnail;
    $html .= '</a></div>';
    $category_names = array();
    foreach( $get_terms as $term ) { 
      $category_names[] = $term->name;
    }
    $html .= '<div class="cate-blog">' .implode( ", ", $category_names ). '</div>';
    $html .= '</div>';
    $html .= '<div class="wrap-content">';
    $html .= '<div class="date-blog">' .$date. '</div>';
    $html .= '<h4 class="title-blog"><a href="'.$the_permalink.'">'.$title.'</a></h4>';
    $html .= '<div class="read-more"><a href="'.$the_permalink.'">'.__('Read More', 'roofresto').'</a></div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
  endwhile;
  $html .= the_posts_pagination();
  if ($number_of_page > 1) {
    $html .= '<div class="wp-block-query-pagination">';
    $html .= '<div class="wp-block-query-pagination-numbers">';
    $items_before_after = 2;
    $start_item = max(1, $paged - $items_before_after);
    $end_item = min($number_of_page, $paged + $items_before_after);
    if ($start_item > 1) {
      $html .= '<a class="page-numbers" href="javascript:void(0)" data-paged="1">1</a>';
    }
    if ($start_item > 2) {
      $html .= '<span class="ellipsis">...</span>';
    }
    for ($i = $start_item; $i <= $end_item; $i++) {
      if ($i == $paged) {
        $html .= '<a class="page-numbers current" href="javascript:void(0)" data-paged="' . $i . '">' . $i . '</a>';
      } else {
        $html .= '<a class="page-numbers" href="javascript:void(0)" data-paged="' . $i . '">' . $i . '</a>';
      }
    }
    if ($end_item < $number_of_page - 1) {
      $html .= '<span class="ellipsis">...</span>';
    }
    if ($end_item < $number_of_page) {
      $html .= '<a class="page-numbers" href="javascript:void(0)" data-paged="' . $number_of_page . '">' . $number_of_page . '</a>';
    }
    $html .= '</div>';
    $html .= '</div>';
  }
  wp_reset_postdata();
  $data = [
    'html' => $html,
    'max_page' => $loop->max_num_pages,
    'current_page' => (int)$paged,
  ];
  wp_send_json_success($data);
  die();
}

function script_wp_footer()
{
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>	
	<?php
}
add_action('wp_footer', 'script_wp_footer', 15);
