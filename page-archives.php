<?php get_header(); ?>

        <div class="col-sm-9 blog-main">

            <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post() ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
                <?php the_title('<h1 class="post-title page-header">', '</h1>'); ?>
                <div class="entry-summary">
                    <?php the_content(sprintf('Continue reading %s', the_title( '<span class="screen-reader-text">', '</span>', false))); ?>
                </div>
            </article>
            <?php endwhile; ?>
            <?php endif; ?>

            <div class="entry-summary row">
              <div class="col-sm-6">
                  <h3>By category</h3>
                  <ul class="archive-list">
                      <?php wp_list_categories(['title_li' => null]); ?>
                  </ul>
              </div>
              <div class="col-sm-6">
                  <h3>By year</h3>
                  <ul class="archive-list">
                      <?php wp_get_archives('type=yearly'); ?>
                  </ul>
              </div>
            </div>
            <p class="post-meta meta list-post-meta">
                <?php edit_post_link('<span>Edit page</span>', '<span class="edit-link"> ', '</span>'); ?>
            </p>
        </div>

    <?php get_sidebar(); ?>

<?php get_footer(); ?>
<!-- page-archives.php -->
