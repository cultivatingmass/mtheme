<?php
/**
 * The template for displaying all single posts.
 *
 * @package onetone
 */

get_header(); 
$left_sidebar           = onetone_option('left_sidebar_blog_posts');
$right_sidebar          = onetone_option('right_sidebar_blog_posts');
$display_author_info    = onetone_option('display_author_info',1 );
$display_related_posts  = onetone_option('display_related_posts',1 );

$aside          = 'no-aside';
if( $left_sidebar !='' )
$aside          = 'left-aside';
if( $right_sidebar !='' )
$aside          = 'right-aside';
if(  $left_sidebar !='' && $right_sidebar !='' )
$aside          = 'both-aside';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

        
<div class="post-wrap">
            <div class="container">
                <div class="post-inner row <?php echo $aside; ?>">
                    <div class="col-main">
                        <section class="post-main" role="main" id="content">
                         <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article class="post type-post">
                            <?php if (  has_post_thumbnail() ): ?>
                                <div class="feature-img-box">
                                    <div class="img-box">
                                            <?php the_post_thumbnail();?>
                                    </div>                                                 
                                </div>
                                <?php endif;?>
                                <div class="entry-main">
                                    <div class="entry-header">                                            
                                        <h1 class="entry-title"><?php the_title();?></h1>

                                    </div>
                                    <div class="entry-content">                                        
                                        <?php the_content();?>      
                                        <?php
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'onetone' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
				?>
                                    </div>
                                    <div class="entry-footer">
                                        <?php
												if(get_the_tag_list()) {
													echo get_the_tag_list('<ul class="entry-tags no-border pull-left"><li>','</li><li>','</li></ul>');
												}
												
												$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
												?>
                                    </div>
                                </div>
                            </article>
<?php endwhile; // end of the loop. ?>
<?php endif;?>
                            <div class="post-attributes">
							<?php if( $display_author_info == 1 ):?>
                                <!--About Author-->
                                <div class="about-author">
                                    <h3><?php _e("About the author","onetone");?>: <?php the_author_link(); ?></h3>
                                    <div class="author-avatar">
                                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?>
                                    </div>
                                    <div class="author-description">
                                        <?php the_author_meta('description');?>
                                    </div>
                                </div><!--About Author End-->
                                <?php endif;?>
                                
                                 <?php if( $display_related_posts == 1 ):?>
                                <?php 
								
									$related_number = onetone_option('related_number',8);
									$related        = onetone_get_related_posts($post->ID, $related_number,'post'); 
									
									?>
			                        <?php if($related->have_posts()): 
									?>
                               
                                <!--Related Posts-->
                                <div class="related-posts">
                                        <h3><?php _e( 'Related Posts', 'onetone' );?></h3>
                                        <div class="multi-carousel onetone-related-posts owl-carousel owl-theme">
                                        
                            <?php while($related->have_posts()): $related->the_post(); ?>
							<?php if(has_post_thumbnail()): ?>
                            <?php
							       $thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'related-post');
								   if( $thumb_image[0] != '' ):
							?>
                                            <div class="owl-item">
                                            <div class="post-grid-box">
                                                                <div class="img-box figcaption-middle text-center from-left fade-in">
                                                                    <a href="<?php the_permalink(); ?>">
                                                                        <img src="<?php echo $thumb_image[0];?>" class="feature-img"/>
                                                                        <div class="img-overlay">
                                                                            <div class="img-overlay-container">
                                                                                <div class="img-overlay-content">
                                                                                    <i class="fa fa-link"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>                                                  
                                                                </div>
                                                                <div class="img-caption">
                                                                    <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                                                                    <ul class="entry-meta">
                                                                        <li class="entry-date"><i class="fa fa-calendar"></i><?php echo get_the_date( );?></li>
                                                                        <li class="entry-author"><i class="fa fa-user"></i><?php echo get_the_author_link();?></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            </div>
                                            <?php endif; endif; endwhile; ?>
                                        </div>
                                    </div>
                                <!--Related Posts End-->
                                <?php wp_reset_postdata(); endif; ?>
                                <?php endif; ?>
                                <!--Comments Area-->                                
                                <div class="comments-area text-left">
                                     <?php
											// If comments are open or we have at least one comment, load up the comment template
											if ( comments_open()  ) :
												comments_template();
											endif;
										?>
                                </div>
                                <!--Comments End-->
                                      </div>
                            
                            
                        </section>
                    </div>
                    <?php if( $left_sidebar !='' ):?>
                    <div class="col-aside-left">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                                <?php get_sidebar('postleft');?> 
                            </div>
                        </aside>
                    </div>
                    <?php endif; ?>
                    <?php if( $right_sidebar !='' ):?>
                    <div class="col-aside-right">
                       <?php get_sidebar('postright');?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>  
        </div>

      </article>
<?php get_footer(); ?>