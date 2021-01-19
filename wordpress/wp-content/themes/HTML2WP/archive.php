<!-- Main -->
<?php get_header()?>

<section id="main">
					<div class="container">
						<div class="row">
							<div class="col-8 col-12-medium">

                                <!-- Content -->
                                
                                <?php
                                if (have_posts()){

                                    while(have_posts()){
                                        the_post();?>

                                        <article class="box post">
                                            <a href="<?php  the_permalink()?>" class="image featured"><img src="images/pic01.jpg" alt="" />
                                                   <?php the_post_thumbnail('single-post')?>                                         
                                        </a>
                                            <header>
                                                <h2><?php the_title()?></h2>
                                                
                                            </header>
                                            <?php the_content()?>
                                        </article>
                                        
                                        <?php
                                    }
                                }
                                ?>
									
										
										
										
										
									</article>

							</div>
							<div class="col-4 col-12-medium">

								<?php get_sidebar()?>
									

							</div>
						</div>
					</div>
</section>

<?php get_footer()?>