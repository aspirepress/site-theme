<?php get_header(); ?>

        <div class="col-sm-9 blog-main">

            <header class="archive-header page-header">
              <h1 class="archive-title">Category: <?php echo single_cat_title('', false); ?></h1>

              <?php if ( category_description() ) : // Show an optional category description ?>
              <div class="archive-meta"><?php echo category_description(); ?></div>
              <?php endif; ?>
            </header>


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

    <?php get_sidebar(); ?>

<?php get_footer(); ?>
<!-- category.php -->
