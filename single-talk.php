<?php get_header(); ?>

		<div class="col-sm-9 blog-main">
			<?php if ( have_posts() ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<?php get_template_part( 'content', get_post_type() ); ?>

				
					<?php akrabat3_post_nav(); ?>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
	<?php get_sidebar(); ?>

<?php get_footer(); ?>
<!-- single-talk.php -->
