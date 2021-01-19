<?php/*
title:this is used to add libraries

*/?>

<!DOCTYPE html>
<html lang="en">

<head>

<title>
<?php echo get_the_title();?> |
    <?php  bloginfo('name')?>
   
</title>
<?php wp_head() // is function se automaticall stylesheets or scripts output hojen gi ye functions ko call karta h jo k functions.php me banay hote hn files ko include krne k leay?>
<style>

  .site-navigation{
    background:<?php  echo get_theme_mod('wp_nav_bg','#2ca358') ?>
  }

  body{
    background:<?php  echo get_theme_mod('wp_bg','#2ca358') ?>
  }
</style>
</head>

<body>



<header class="w3-container w3-center w3-padding-32 "> 
  <a href="<?php bloginfo('url')?>">
  <div class="w3-circle setimg">
      <?php the_custom_logo()?>
</div>
</a>
  <p>Welcome to the blog of <span class="w3-tag">unknown</span></p>
</header>



<ul class="site-navigation">
  <li><?php wp_nav_menu(array ('theme_location' => 'primary'))?></li>
 
  
</ul>




