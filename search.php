<?php get_header(); ?>

        <div class="col-sm-9 search-main">

            <header class="search-header page-header">
            <?php 
            $type = '';
            if ((isset($_GET['post_type']) && $_GET['post_type'] == 'talk')) {
                    $type = ' (talks only)';
            } ?>
                <h1 class="page-title"><?php printf(__('Search Results for: %s', 'shape'), '<span>' . get_search_query() . '</span>' . $type); ?></h1>
            </header>

            <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post() ?>
                <?php get_template_part('content', get_post_format()) ?>
            <?php endwhile; ?>
            <?php else: ?>
                <p>No results found</p>
                
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
<!-- index.php -->
