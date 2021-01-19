
<?php get_header();?>


<div class="w3-content h-img">
<img src="<?php header_image()?>"><!--ye function custom header image show karvata hai iska predefine function hamari functions,php ki class me hai-->
<div class="w3-row">
 <div class="w3-col l8 ">

 <?php 
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); ?>
  
<div class="w3-card-4 w3-margin-top w3-center post-img">
       <a href="<?php the_permalink()?>"><?php the_post_thumbnail('large');?></a>
       <div class="w3-container w3-center w3-margin-top">
       <a href="<?php the_permalink(get_the_ID())?>"><h2><?php the_title()?></h2></a>
  </div>
  <div class="w3-container w3-center ">
    <p><?php the_excerpt()?></p>
    <p><strong>Author: </strong><?php the_author() ?> | <?php  the_time()?></p>
  </div>
       </div>  
 
    <?php endwhile; 
endif; 
?>

<div class="w3-container w3-padding">
  

<div class="w3-bar">
  <a href="#" class="w3-button"><?php echo paginate_links()?></a>
  
</div>

</div>
</div>

 <div class="w3-col l4 w3-light-grey">

 <?php get_sidebar();?>
 </div>

</div>    
</div>
</div>

<?php 

get_footer();
?>

