
<?php get_header();?>
<div class="w3-content h-img">

<div class="h-img">
    <?php $img_url=get_the_post_thumbnail_url(get_the_ID(), '')?><!--ye hamari header post ko show karri hai jo k hm feature image set krte hain-->
    <img src="<?php echo $img_url?>" >
    
</div>
<?php 
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); ?>
        <h1><?php the_title() ?></h1>
        <p><?php the_content()?></p>


<?php endwhile;?>
<?php endif; ?>

<?php 
get_sidebar();
get_footer();
?>

</div>