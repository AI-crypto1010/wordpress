<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */

$sidebar_location = 'right';
if(!empty(pix_get_option('blog-layout'))){
	if(pix_get_option('blog-layout')=='left-sidebar'){
		$sidebar_location = 'left';
	}
}
if(!empty($_GET["blog_layout"])){
	switch ($_GET["blog_layout"]) {
		case 'right-sidebar':
			$sidebar_location = 'right';
			break;
		case 'left-sidebar':
			$sidebar_location = 'left';
			break;
	}
}

$attr = array(
	'class' => 'rounded-xl shadow'
);

if($sidebar_location=='left'){
	get_sidebar();
}
$post_sidebar_class = 'post-sidebar-'.$sidebar_location;
?>

<div class="col-12 col-md-8">
		<main id="main" class="site-main content-area pix-post-area pix-post-sidebar-area">

			<article id="post-<?php the_ID(); ?>" <?php post_class($post_sidebar_class); ?>>
				<?php
					$post_thumb = false;
					if(!empty(pix_get_option('post-with-intro'))&&pix_get_option('post-with-intro')){
						$post_thumb = true;
					}
					if(!empty($_GET["post_intro"])){
						switch ($_GET["post_intro"]) {
							case 'true':
								$post_thumb = true;
								break;
							case 'false':
								$post_thumb = false;
								break;
						}
					}
						$attr = array(
							'class' => 'rounded-xl shadow'
						);
						pixfort_post_thumbnail('post-thumbnail', $attr);
	
				$show_author_name = true;
				if( !empty(pix_get_option('pix-disable-post-author')) ){
					if(pix_get_option('pix-disable-post-author')){
						$show_author_name = false;
					}
				}
				$show_categories = true;
				if( !empty(pix_get_option('pix-disable-post-categories')) ){
					if(pix_get_option('pix-disable-post-categories')){
						$show_categories = false;
					}
				}
				$show_date = true;
				if( !empty(pix_get_option('pix-disable-post-date')) ){
					if(pix_get_option('pix-disable-post-date')){
						$show_date = false;
					}
				}
				if( $show_author_name || $show_categories || $show_date ){
				?>
				<header class="entry-header">
					<?php

						if ( 'post' === get_post_type() ) :

							$author = get_the_author();


							$cat_args = array( 'fields' => 'names' );
							$cat_args = array( 'fields' => 'all' );
						    $cats = wp_get_post_categories(get_the_ID(), $cat_args);



							$post_intro = true;
							if(!pix_get_option('post-with-intro')){
								$post_intro = false;
							}
							if(!empty($_GET["post_intro"])){
				                switch ($_GET["post_intro"]) {
				                    case 'true':
				                        $post_intro = true;
				                        break;
				                    case 'false':
				                        $post_intro = false;
				                        break;
				                }
				            }
							if(!$post_intro){
								$disableTitle = false;
								if( !empty(pix_get_option('pix-disable-post-title')) ){
									if(pix_get_option('pix-disable-post-title')){
										$disableTitle = true;
									}
								}
								if(!$disableTitle){
									$text_class = 'text-heading-default';
									$title_sliding = true;
									if( !empty(pix_get_option('blog-disable-title-animation')) ){
										if(pix_get_option('blog-disable-title-animation')){
											$title_sliding = false;
										}
									}
									if($title_sliding&&class_exists('PixfortCore')){
										echo \PixfortCore::instance()->elementsManager->renderElement('SlidingText', [
											'position'  => 'inherit',
											'size'  => 'h1',
											'secondary_font'  => 'secondary-font',
											'el_class'  => $text_class . ' pix-post-title h4 pix-mt-20 font-weight-bold',
											'el_id'  => 'pix-intro-sliding-text',
											'remove_mb'  => true
										],  get_the_title());
									}else{
										the_title( '<h1 class="pix-post-title h4 pix-mt-20 '.$title_sliding.' font-weight-bold" data-class="'.$text_class.'">', '</h1>', true );
									}
								}
							}

					?>

							<div class="entry-meta pix-post-meta-inner d-flex align-items-center pix-mt-20">
							<?php
								if( $show_author_name ){
							?>
								<div class="flex-fill pix-post-meta-author text-heading-default font-weight-bold">
									<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="text-heading-default font-weight-bold">
									<?php
										$margin10 = 'pix-mr-10';
										if (is_rtl()) {
											$margin10 = 'pix-ml-10';
										}  
										echo get_avatar(get_the_author_meta('ID'), 40, '', $author, array( 'class'=>'pix_blog_md_avatar '.$margin10.' shadow'));
									?>
									<span class="text-sm"><?php echo esc_html( $author ); ?></span>
									</a>
								</div>
								<?php
									}
									if( $show_categories ){
								?>
								<div class="flex-fill text-right mr-2">
									<div class="pix-post-meta-badges">
										<?php
										foreach ($cats as $value) {
											$badge_attrs = array(
												'text'	=> $value->name,
												'text_size'	=> 'custom',
												'text_custom_size'		=> '12px',
												'bold'  => 'font-weight-bold',
												'secondary-font'  => 'secondary-font',
												'custom_css'	=> 'padding:5px 10px;line-height:14px;',
												'link'      => get_category_link($value->term_id)
											);
											if(class_exists('PixfortCore')){
												echo \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs );
											}else{
												?>
										            <a href="<?php echo esc_url(get_category_link($value->term_id)); ?>">
											    		<span class="d-inline-block mr-1">
											    			<span class="badge bg-primary-light text-primary pix-px-10 pix-py-5" style="line-height:14px;">
											    				<span class="" style="font-size:12px;">
											    					<?php echo esc_html($value->name); ?>
											    				</span>
											    			</span>
											    		</span>
										    		</a>
												<?php
											}
										}
										?>
									</div>
								</div>
								<?php
									}
									if( $show_date ){
								?>
								<div class="pix-post-meta-date flex-fill2 text-right text-body-default text-sm">
									<a class="mb-0 d-inline-block text-body-default svg-body-default" href="<?php echo get_permalink(); ?>">
										<span class="pr-1">
											<?php echo pixGetThemeFileContents('/inc/assets/blog/blog-post-date-icon.svg'); ?>
										</span>
										<span class="text-xs font-weight-bold"><?php echo get_the_date(); ?></span>
									</a>
								</div>
								<?php
									}
								?>
							</div><!-- .entry-meta -->
					<?php endif; ?>
				</header><!-- .entry-header -->
				<?php
				}
				?>

	<div class="entry-content pix-mt-20" id="pix-entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'conseil' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_attr__( 'Pages:', 'conseil' ),
			'after'  => '</div>',
		) );

		$tags = '';
		if(get_the_tags()){
			?>
			<div class="clearfix w-100"></div>
			<div class="pix-py-20 pix-post-tags">
				<?php
				foreach (get_the_tags() as $value) {
					?>
					<a href="<?php echo get_tag_link( $value ); ?>" class="btn btn-sm btn-white shadow-sm shadow-hover-sm text-xs2 text-body-default fly-sm pix-mr-10 pix-mb-10 font-weight-bold"><?php echo esc_html( $value->name ); ?></a>
					<?php
				}
				?>
			</div>
			<?php
		}



		?>



		<div class="pix-floating-meta pix-post-meta-box">
			<?php do_action( 'pix_post_meta_box_start'); ?>
			<?php
				if( function_exists('get_pixfort_likes') ){
					?>
					<div class="bg-white shadow-sm rounded-lg w-100 pix-py-10 pix-mb-10 text-center line-height-1">
						<?php
						echo get_pixfort_likes();
						?>
					</div>
					<?php
				}
				if(comments_open()){
			?>
				<div class="pix-post-meta-comments bg-white shadow-sm rounded-lg w-100 pix-py-10 pix-mb-10 text-center line-height-1">
					<a href="<?php echo esc_url( get_comments_link() ); ?>" class="text-xs text-body-default svg-body-default">
						<span class="pr-1">
							<?php echo pixGetThemeFileContents('/inc/images/blog/blog-post-comments-icon.svg'); ?>
						</span>
						<span class="align-middle font-weight-bold"><?php echo esc_html( get_comments_number() ); ?></span>
					</a>
				</div>
			<?php } ?>
			<?php do_action( 'pix_post_meta_box_end'); ?>
		</div>



	</div><!-- .entry-content -->

	
	
		<?php


		$show_author_box = true;
		if( !empty(pix_get_option('pix-disable-blog-author-box')) ){
			if(pix_get_option('pix-disable-blog-author-box')){
				$show_author_box = false;
			}
		}
		if($show_author_box){

			if(!empty(get_the_author_meta('first_name'))){
				$author = get_the_author_meta('first_name');
				$author .= ' '. get_the_author_meta('last_name');
			}else{
				$author = get_the_author();
			}


			?>
			<footer class="entry-footer d-inline-block w-100">
				<div class="media bg-white rounded-xl shadow-sm pix-p-30 pix-my-20">
				<?php
					$margin30 = 'pix-mr-30';
					if (is_rtl()) {
						$margin30 = 'pix-ml-30';
					}  
					echo get_avatar(get_the_author_meta('ID'), 80, '', $author, array( 'class'=>'pix_blog_lg_avatar '.$margin30.' shadow'));
				?>
				<div class="media-body">
					<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><div class="h6 mt-0 font-weight-bold text-heading-default"><?php echo esc_html( $author ); ?></div></a>
					<?php
						if(!empty(get_the_author_meta('user_url'))){
							$url_txt = get_the_author_meta('user_url');
							if(strpos($url_txt, 'http://') === 0){
								$url_txt = substr($url_txt, strlen('http://'));
							}
							if(strpos($url_txt, 'https://') === 0){
								$url_txt = substr($url_txt, strlen('https://'));
							}
							?>
							<a class="text-sm text-heading-default font-weight-bold" href="<?php echo esc_url ( get_the_author_meta('user_url') ); ?>"><?php echo esc_html( $url_txt ); ?></a>
							<?php
						}
					if(!empty(get_the_author_meta( 'description' ))){ ?>
						<p class="mb-0 pix-pt-20"><?php the_author_meta( 'description' ); ?></p>
					<?php } ?>
				</div>
				</div>
			</footer><!-- .entry-footer -->
		<?php } ?>




	

<?php
	$show_social = true;
	if( !empty(pix_get_option('pix-disable-blog-social')) ){
		if(pix_get_option('pix-disable-blog-social')){
			$show_social = false;
		}
	}
	if($show_social){
		get_pix_social_links();
	}

?>
</article>
			</main><!-- #main -->
	</div>

	<?php
		// Right Sidebar
		if($sidebar_location!='left'){
			get_sidebar();
		}
	?>

	<!-- Post navigation -->
	<div class="col-12">
		<?php pix_post_navigation(); ?>
	</div>


	<?php
		// Related posts
		get_pix_related_posts();
	?>


	<?php
		// Comments
		if ( comments_open() || get_comments_number() ) :
			?>
			<div class="col-12 col-md-8 offset-md-2 pix-py-40">
				<?php comments_template(); ?>
			</div>
			<?php
		endif;

	?>
