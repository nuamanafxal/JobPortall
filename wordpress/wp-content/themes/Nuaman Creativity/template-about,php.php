<?php  
/*
Template Name: About Template
*/ 
?>
<?php get_header();?>

<div class="w3-content  ">
    
    <div class=" w3-col l8 w3-white">

        <?php 
        if ( have_posts() ) : 
            while ( have_posts() ) : the_post(); ?>
                <h1><?php the_title() ?></h1>
                <p><?php the_content()?></p>


        <?php endwhile;?>
        <?php endif; ?>
    </div>


   <div class="w3-col l4 w3-white">
        <?php 
        get_sidebar();
        ?>
    </div>



    <div class="w3-red">
        <?php
    get_footer();
    ?>
    </div>
</div>   