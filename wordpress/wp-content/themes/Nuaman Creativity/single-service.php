<?php /*
display posts
*/ ?>

<?php get_header()?>

<?php 
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); ?>
  
<div class="w3-card-4 w3-margin-top w3-center post-img">
<h1 class="w3-text-white">single-service</h1>
       <a href="<?php the_permalink()?>"><?php the_post_thumbnail('medium');?></a>
       <div class="w3-container w3-center w3-margin-top">
       <a href="<?php the_permalink()?>"><h2><?php the_title()?></h2></a>
  </div>
  <div class="w3-container w3-center ">
    <p><?php the_content();?></p>
   
  </div>
       </div>
 
    <?php endwhile; 
endif; 
?>

<?php get_footer()?>