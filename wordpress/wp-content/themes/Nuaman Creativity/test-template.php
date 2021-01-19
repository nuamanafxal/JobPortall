
<?phph  /* 
Template Name: Test Template
*/?>

<?php get_header();?>

<div class="h-img w3-content">
    <?php $img_url=get_the_post_thumbnail_url(get_the_ID(), '')?><!--ye hamari header post ko show karri hai jo k hm feature image set krte hain-->
    <img src="<?php echo $img_url?>" >
</div>

<div class="w3-content h-img" >

<?php 
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); ?>
        <h1><?php the_title() ?></h1>
        
            <p class="w3-center"><?php the_content()?></p>
        
        <p class="w3-center"><?php the_content()?></p>
        
<?php endwhile;?>
<?php endif; ?>
<?php   wp_reset_postdata();?>
</div>



<section class="services">
    <div class="w3-row w3-content" >
<?php 

$args= array( 
    'post_type' => 'service',
    'posts_per_page'=>3,
    'order' => 'ASC',
);
$texh_posts=new Wp_Query($args);
//$texh_posts = new WP_Query( array( 'category__in' => 3 ) );

if (  $texh_posts->have_posts()) : ?>
   <?php  while ( $texh_posts ->have_posts() ) :  $texh_posts->the_post(); ?>
   
    <div class="w3-col l4">
        <div class="w3-padding">

                <div class="w3-col l12">

                    <div class="img-h-w">
                        <?php the_post_thumbnail('thumbnail')?>
                    </div>  
                <!--l12-->
                    
                        <a href="<?php echo get_the_permalink(get_the_ID())?>"><?php the_title()?></a>
                        <p><?php the_excerpt();?></p>
                </div>  <!--l12-->

        </div><!--padding-->
    </div> <!--w3-col l4 -->
 
     
    <?php endwhile;?>
    <?php endif; ?>
    <?php   wp_reset_postdata();?>
</div> <!--row-->
</section>  

<!--section-caroiusel-->
<section class="carousel">
    <div class="w3-row w3-content">
        <div class="owl-carousel">
        <?php 

$args= array( 
    'post_type' => 'project',
    'posts_per_page'=>9,
    'order' => 'ASC',
);
$texh_posts=new Wp_Query($args);
//$texh_posts = new WP_Query( array( 'category__in' => 3 ) );

if (  $texh_posts->have_posts()) : ?>
   <?php  while ( $texh_posts ->have_posts() ) :  $texh_posts->the_post(); ?>
   
    <div class="">
        <?php   the_post_thumbnail('medium')?>


    </div> <!--w3-col l4 -->
 
     
    <?php endwhile;?>
    <?php endif; ?>
    <?php   wp_reset_postdata();?>
        </div>


    </div>

</section>

    <br>
<div class="w3-row">
    <div class="w3-col l6 ">
        <div class=" w3-padding">

            <header class="w3-container w3-blue">
            <h2>Latest From Technology</h2>
            </header>

            <div class="w3-container">
            <?php 

            $args= array( 
                'cat' => '3',
                'posts_per_page'=>1
            );
            $texh_posts=new Wp_Query($args);
            //$texh_posts = new WP_Query( array( 'category__in' => 3 ) );

            if (  $texh_posts->have_posts()) : ?>
               <?php  while ( $texh_posts ->have_posts() ) :  $texh_posts->the_post(); ?>
                   <div class="w3-row">
                    <div class="w3-col l4 ">
                        <div class="img-h-w">
                <?php the_post_thumbnail('thumbnail')?>
            </div>
                    </div>

                    <div class="w3-col l8">
                    <h3 class="w3-padding"><?php the_title()?></h3>
                    <p class="w3-margin w3-small"><?php the_excerpt()?></p>
                    </div>
                  </div>  
                <?php endwhile;?>
                <?php endif; ?>
                <?php   wp_reset_postdata();?>
            </div>

            <footer class="w3-container w3-blue">
            <h5>Footer</h5>
            </footer>
        </div>

    </div>
    <div class="w3-col l6 ">
        <div class=" w3-padding">

            <header class="w3-container w3-blue">
            <h2>Latest From News</h2>
            </header>

            <div class="w3-container">
            <p>Lorem ipsum...</p>
            </div>

            <footer class="w3-container w3-blue">
            <h5>Footer</h5>
            </footer>
        </div>

    </div>



</div>

</div><!--content idv-->
<?php 

get_footer();
?>

</div>
