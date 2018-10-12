<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

get_header(); ?>

<!-- Wrapper start -->
<div class="main">

	<?php
	if ( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) || ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'lost-password' ) ) || ( function_exists( 'is_account_page' ) && is_account_page() ) ) :
		echo '<section class="module module-cart-top">';
	else :

		$thumb_tmp = get_the_post_thumbnail_url();

		$shop_isle_header_image = get_header_image();
		if ( ! empty( $thumb_tmp ) ) {
			echo '<section class="page-header-module module bg-dark" data-background="' . esc_url( $thumb_tmp ) . '">';
		} elseif ( ! empty( $shop_isle_header_image ) ) {
			echo '<section class="page-header-module module bg-dark" data-background="' . esc_url( $shop_isle_header_image ) . '">';
		} else {
			echo '<section class="page-header-module module bg-dark">';
		}

	endif;
	?>

	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="module-title font-alt"><?php the_title(); ?></h1>


			</div>
		</div>

	</div><!-- .container -->

	<?php
	echo '</section>';
	?>


	<!-- Pricing start -->

	<div class="container">
        <div class="grid">

        
    <?php $args = array(
                'post_type' => 'post',
                'category_name'    => 'events',
                'order' => 'des',
                'orderby' => 'date',
				'posts_per_page' => '-1',
			);
			$work = new WP_Query( $args );
			if ( $work->have_posts() ) :  while ( $work->have_posts() ) : $work->the_post();
			$url = get_post_meta($post->ID, 'url', true); ?>


            <?php $postImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); ?>
            <article id="post-<?php the_ID(); ?>" class="grid-item">

                <img class="post-image" src="<?php echo $postImg['0'];?>" alt="<?php the_title(); ?>">
                <?php if ( get_post_thumbnail_id() ) { ?>

                <div class="portfolio-thumbnail">
                    <a href="<?php echo $url; ?>" target="_blank"></a>
                </div>

                <?php } ?>
                <!-- <a href="/<?php the_permalink(); ?>"> -->
                    <div class="post-description">
                        <h1 class="post-title letter-space text-alt">

                            <?php the_title(); ?>


                        </h1>
                        <?php the_content(); ?>
                        
                        <!-- <?php the_excerpt(); ?>-->
                    </div>
                <!-- </a> -->
            </article>

            <?php endwhile; endif; wp_reset_postdata(); ?>

        </div>
	</div>

		<!-- Pricing end -->


<?php get_footer(); ?>
