            <?php
                $categories_list = explode('§', get_the_category_list('§'));
                $tag_list = explode('§', get_the_tag_list('', '§'));
                $list = $categories_list + $tag_list;
                $list = implode(', ', $list);
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post h-entry'); ?>>
            <?php
                if (is_singular()) :
                    the_title('<h1 class="post-title page-header p-name">', '</h1>');
                else :
                    $type = '';
                    if (is_search()) {
                        $postType = get_post_type();
                        if ($postType == 'talk') {
                            $type = ucfirst($postType);
                            $customFields = get_post_custom();
                            if (!empty($customFields['talk_event'])) {
                                $type = current($customFields['talk_event']);
                                $type = str_replace('user group', '', $type);
                                $type = trim($type);
                            }
                            if (!empty($customFields['talk_date'])) {
                                $type .= ' ' .  date('Y', strtotime(current($customFields['talk_date'])));
                            }

                            $type .= ': ';
                        }
                    }
                    the_title(sprintf('<h2 class="post-title"><a href="%s" rel="bookmark">' . $type, esc_url(get_permalink())), '</a></h2>');
                endif;
            ?>

                <?php if (is_search()) : // Only display Excerpts for Search ?>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                    <p class="post-meta meta list-post-meta">Posted on
                            <?php the_date(); ?>
                            in <span class="categories-links"><?php echo $list ?></span>

                        <?php
                        if ( comments_open() && ! is_singular() ) : ?>
                            <span class="comments-link meta-segment">
                                <?php comments_popup_link('<span class="leave-reply">Leave a comment</span>', 'One comment so far', 'View all % comments'); ?>
                            </span>
                        <?php endif; // comments_open() ?>

                        <?php edit_post_link('<span>Edit</span>', '<span class="edit-link meta-segment"> ', '</span>'); ?>
                    </p>
                </div>
                <?php elseif (!is_singular()) : // Only display Excerpts list pages ?>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                    <p class="post-meta meta list-post-meta">Posted on
                            <?php the_date(); ?>
                            in <span class="categories-links"><?php echo $list ?></span>

                        <?php
                        if ( comments_open() && ! is_singular() ) : ?>
                            <span class="comments-link meta-segment">
                                <?php comments_popup_link('<span class="leave-reply">Leave a comment</span>', 'One comment so far', 'View all % comments'); ?>
                            </span>
                        <?php endif; // comments_open() ?>

                        <?php edit_post_link('<span>Edit</span>', '<span class="edit-link meta-segment"> ', '</span>'); ?>
                    </p>
                </div>
                <?php else :
                    // single post page
                    echo "<div class=\"e-content\">\n";
                    if (has_post_thumbnail()):
                        the_post_thumbnail('large', ['style' => 'max-width:100%; height:auto']);
                    endif;
                    the_content(sprintf('Continue reading %s', the_title( '<span class="screen-reader-text">', '</span>', false)));
                    echo "\n</div>\n";

                    if (is_singular('post')): ?>
                        <p class="post-meta meta singular-post-meta">This article was posted on
                                <time class="dt-published" datetime="<?php the_date('Y-m-d H:i:s'); ?>" title="<?php echo get_the_date('Y-m-d H:i:s'); ?>"><?php echo get_the_date(); ?></time>
                                in <span class="categories-links"><?php echo $list ?></span>
                        </p>
                    <?php endif;

                    wp_link_pages([
                        'before' => '<div class="page-links"><span class="page-links-title">Pages</span>',
                        'after' => '</div>',
                        'link_before' => '<span>',
                        'link_after' => '</span>',
                    ]);

                    
                    if ( false && comments_open() && ! is_singular() ) : ?>
                        <div class="comments-link meta">
                            <?php comments_popup_link('<span class="leave-reply">Leave a comment</span>', 'One comment so far', 'View all % comments'); ?>
                        </div>
                    <?php endif; // comments_open()
                ?>
                <?php endif; ?>
          </article>
