<?php get_header(); ?>

        <div class="col-sm-9 blog-main">

            <header class="archive-header page-header">
              <h1 class="archive-title"><?php
                if ( is_day() ) :
                  printf( __( 'Daily Archives: %s', 'twentythirteen' ), get_the_date() );
                elseif ( is_month() ) :
                  printf( __( 'Monthly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentythirteen' ) ) );
                elseif ( is_year() ) :
                  printf( __( 'Yearly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentythirteen' ) ) );
                else :
                  _e( 'Archives', 'twentythirteen' );
                endif;
              ?></h1>
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

        </div><!-- /.blog-main1 -->

    <?php get_sidebar(); ?>

<?php get_footer(); ?>
<!-- archive.php -->
