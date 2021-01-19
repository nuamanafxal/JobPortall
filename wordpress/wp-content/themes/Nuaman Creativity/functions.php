<?php


add_theme_support( 'custom-logo' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support('archive');

add_theme_support( 'automatic-feed-links' );


register_nav_menus( array(
    'primary'   => __( 'Primary Menu', 'NuamanTheme' ),
   
    
) );



function add_theme_scripts(){

wp_enqueue_style( 'style', get_stylesheet_uri());



wp_enqueue_script('jquery');

wp_enqueue_style('bootstrap-min-css', get_template_directory_uri().'/assets/css/bootstrap.min.css');

wp_enqueue_style('custom', get_template_directory_uri().'/assets/css/custom.css');
}

add_action('wp_enqueue_scripts','add_theme_scripts')//ye head or footer me jo scripts ouput honi oti hn usko ko handle karta h


?>


<?php  

function theme_scripts(){
wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/assets/bootstrap.min.js');

wp_enqueue_script('owl-css', get_template_directory_uri().'/owl.carousel.min.js');

wp_enqueue_style('owl-css', get_template_directory_uri().'/owl-carousel/assets/owl.carousel.min.css');

wp_enqueue_script('myjs-js', get_template_directory_uri().'/assets/my-js.js');
}
add_action('wp_enqueue_scripts','theme_scripts')//ye head or footer me jo scripts ouput honi oti hn usko ko handle karta h

?>

<?php
function themename_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'theme_name' ),
        'id'            => 'sidebar-1',
        'description'   =>'Mian Sidebar on Right Side',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer 1', 'theme_name' ),
        'id'            => 'footer-1',
        'description'   =>'Mian Sidebar on Right Side',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
 
    register_sidebar( array(
        'name'          => __( 'Footer 2', 'theme_name' ),
        'id'            => 'footer-2',
        'description'   =>'Mian Sidebar on Right Side',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
 
}

add_action('widgets_init','themename_widgets_init');//hookname and fucntion name

?>




<?php
//cutom header
function themename_custom_header_setup() {
    $args = array(
        'default-image'      => get_template_directory_uri().'/assets/img/ml.jpg',
        'default-text-color' => '000',
       
        'flex-width'         => true,
        'flex-height'        => true,
    );
    add_theme_support( 'custom-header', $args );
};
add_action( 'after_setup_theme', 'themename_custom_header_setup' );





?>


<?php function wpdocs_custom_excerpt_length( $length ) {
    return 10;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );
?>

<?php // customizer fro bp-setting-color changings ets
require get_template_directory().'/inc/customizer.php';
//services post type file is me hm custom post create krte hn iska dashboardenu me naam h
require get_template_directory().'/inc/services.php';

require get_template_directory().'/inc/projects.php';

?>


