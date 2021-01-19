<?php
/*
customizer file
*/ 
?>

<?php function themeslug_customize_register( $wp_customize ) {
 




 $wp_customize->add_panel( 'wp_settings', array(
    'title' => __( 'wp_settings' ),
    'description' => '', // Include html tags such as <p>.
    'priority' => 10, // Mixed with top-level-section hierarchy. ye panel aik menu ki tarah kaam karta hai 
  
  ) );


  $wp_customize->add_section( 'theme_color' , array(
    'title' =>  'Colors',
    'panel' => 'wp_settings', // Before Widgets. ye hm banatay hn panel k andar section banany k leay
  ) );
  


 $wp_customize->add_setting( 'wp_nav_bg', array(
    'type' => 'theme_mod', // or 'option'setting or panel
    'capability' => 'edit_theme_options',
    
    'default' => '',
    'transport' => 'refresh', // or postMessage
    'sanitize_callback' => 'sanitize_hex_color',
   
  ) );
  //setting or panel ki id same oni chaheay like(wp_nav_bg above and below)

  $wp_customize->add_control( 'wp_nav_bg', array(
    'label' => __( 'Menu Background' ),
    'type' => 'color',
    'section' => 'theme_color', //ye control ota hai is se ye pata chalta h k ye kis section ka control hai iski or add section ka argument same ona chaheay 
  ) );

//for body background
$wp_customize->add_setting( 'wp_bg', array(
    'type' => 'theme_mod', // or 'option'setting or panel
    'capability' => 'edit_theme_options',
    
    'default' => '#fff',
    'transport' => 'refresh', // or postMessage
    'sanitize_callback' => 'sanitize_hex_color',
   
  ) );
  //setting or panel ki id same oni chaheay like(wp_nav_bg above and below)

  $wp_customize->add_control( 'wp_bg', array(
    'label' => __( 'Body Background' ),
    'type' => 'color',
    'section' => 'theme_color', //ye control ota hai is se ye pata chalta h k ye kis section ka control hai iski or add section ka argument same ona chaheay 
  ) );

}
add_action( 'customize_register', 'themeslug_customize_register' );

?>