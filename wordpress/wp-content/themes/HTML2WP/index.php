<?php
/*
This template us used to display index page
*/ 
?>

<?php get_header()?>


<section id="main" style="margin-top:-50px;">
					<div class="container">
						<div class="row">
							<div class="col-12">

								<!-- Portfolio -->
									<section>
										<header class="major">
											<h2>My Portfolio</h2>
										</header>
										<div class="row">
											
											
											
										<?php // we are using wp_query
										$portfolio_args=array(
											'post_type' => 'portfolio',
											'posts_per_page' => 6 
										);
										//object
										$portfolio_posts=new WP_query($portfolio_args);
										while($portfolio_posts->have_posts()){
											$portfolio_posts->the_post();
										
										?>
											<div class="col-4 col-6-medium col-12-small">
												<section class="box">
												<a href="<?php  the_permalink()?>" class="image featured"><img src="images/pic08.jpg" alt="" />
													<?php  the_post_thumbnail('custom-size')?>
													</a>
													<header>
														<h3><?php the_title()?></h3>
													</header>
													<p><?php the_title() ?></p>
													
													<footer>
														<ul class="actions">
															<li><a href="#" class="button alt">Find out more</a></li>
														</ul>
													</footer>
												</section>
											</div>
										</div>
										<?php }?>
										<?php wp_reset_postdata()?>
									</section>

		


<?php get_footer();?>