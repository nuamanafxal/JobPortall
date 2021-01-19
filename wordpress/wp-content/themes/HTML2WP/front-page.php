<?php get_header()?>


<?php dynamic_sidebar('banner-1')?>

<!-- Intro -->
<?php dynamic_sidebar('home-services');?>


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

							</div>
							<div class="col-12">

								<!-- Blog -->
									<section>
										<header class="major">
											<h2>The Blog</h2>
										</header>
										<div class="row">
										<?php // we are using wp_query
										$blogs_args=array(
											'post_type' => 'post',
											'posts_per_page' => 6
										);
										//object
										$blogs_posts=new WP_query($blogs_args);
										while($blogs_posts->have_posts()){
											$blogs_posts->the_post();
										
										?>
											<div class="col-6 col-12-small">
												<section class="box">
													<a href="<?php  the_permalink()?>" class="image featured"><img src="images/pic08.jpg" alt="" />
													<?php  the_post_thumbnail('custom-size')?>
													</a>
													<header>
														<h3><?php the_title()?></h3>
														<p><?php the_date()?></p>
													</header>
													<p><?php the_excerpt()?></p>
													<footer>
														<ul class="actions">
															<li><a href="<?php  the_permalink()?>" class="button icon solid fa-file-alt">Continue Reading</a></li>
															<li><a href="<?php  comments_link()?>" class="button alt icon solid fa-comment"><?php echo get_comments_number()?> comments</a></li>
														</ul>
													</footer>
												</section>
											</div>
												<?php }?>
											
										</div>
									</section>

							</div>
						</div>
					</div>
				</section>


<?php get_footer();?>