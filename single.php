<?php
/**
 * The template for displaying all single posts
 */
?>
<?php get_header(); ?>
  
        <div class="col-sm-9 blog-main">

            
            <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post() ?>
                <?php get_template_part('article', get_post_format()) ?>


                

                <?php comments_template(); ?>
                <?php akrabat3_post_nav(); ?>
            <?php endwhile; ?>
            <?php endif; ?>


          <nav>
            <ul class="pager">
              <li><?php next_posts_link('Older') ?></li>
              <li><?php previous_posts_link('Newer') ?></li>
            </ul>
          </nav>

        </div>



<?php get_footer(); ?>
<!-- single.php -->
