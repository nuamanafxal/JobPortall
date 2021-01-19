<?php 
add_theme_support( 'custom-logo' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support('archive');

add_theme_support( 'automatic-feed-links' );
add_image_size( 'custom-size', 680, 300, array('center', 'center') ); 
add_image_size('single-post', 580, 272, array('center','center'));

register_nav_menus( array(
    'primary'   => __( 'Primary Menu', 'NuamanTheme' ),
   
    
) );?>


<?php function add_theme_scripts() {
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'html2wp-browser', get_template_directory_uri().'/assets/browser.min.js' );
  wp_enqueue_script( 'html2wp-breakpoints', get_template_directory_uri().'/assets/breakpoints.min.js' );
  wp_enqueue_script( 'html2wp-main', get_template_directory_uri().'/assets/main.js' );
 
  wp_enqueue_script( 'html2wp-util', get_template_directory_uri().'/assets/util.js' );
  
  
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

?>

<!--sidebars and widgets-->
<?php
function themename_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'theme_name' ),
        'id'            => 'sidebar-1',
        'description'   =>'Mian Sidebar on Right Side',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<header><h3 class="widget-title">',
        'after_title'   => '</h3></header>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'theme_name' ),
        'id'            => 'footer-1',
        'description'   =>'Mian Sidebar on Right Side',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section >',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
      'name'          => __( 'Home Services', 'theme_name' ),
      'id'            => 'home-services',
      'description'   =>'Mian Sidebar on Right Side',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section >',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
  ) );
 
    register_sidebar( array(
        'name'          => __( 'banner 1', 'theme_name' ),
        'id'            => 'banner-1',
        'description'   =>'Banner Area On Home page',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section >',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
      'name'          => __( 'Footer 2', 'theme_name' ),
      'id'            => 'footer-2',
      'description'   =>'Mian Sidebar on Right Side',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section >',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Footer 3', 'theme_name' ),
    'id'            => 'footer-3',
    'description'   =>'Mian Sidebar on Right Side',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section >',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
) );
 
}

add_action('widgets_init','themename_widgets_init');//hookname and fucntion name

?>

<?php  require get_template_directory(). '/inc/portfolio.php'; ?>

<?php
// Trouble with uploading images
add_filter( 'wp_image_editors', 'change_graphic_lib' );

function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}


//tgm includeing




//require_once get_template_directory(). '/inc/class-tgm-plugin-activation.php'; 
//require get_template_directory(). '/inc/install-plugins.php'; 


require get_template_directory(). '/inc/plugins/kirki/kirki.php'; 
require get_template_directory(). '/inc/kirki-config.php'; 


?>
