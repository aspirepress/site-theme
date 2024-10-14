<?php get_header(); ?>

        <div class="container blog-main">
          
            <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post() ?>
                <?php get_template_part('content', get_post_format()) ?>
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
<!-- page.php -->
