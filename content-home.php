<?php
                $categories_list = explode('§', get_the_category_list('§'));
                $tag_list = explode('§', get_the_tag_list('', '§'));
                $list = $categories_list + $tag_list;
                $list = implode(', ', $list);
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post h-entry'); ?>>
            <?php
                if (is_singular()) :
                    //Do Nothing
                endif;
            ?>

                <?php if (is_singular()) :
                    // single post page
                    $author_id = get_the_author_meta( 'ID' );
                    $authorlink = get_the_author_meta( 'user_url', $author_id ) . "/author/" . get_the_author_meta( 'user_login', $author_id );
                    $authorname = get_the_author_meta( 'display_name', $author_id );
                    echo "<div class=\"e-content\">\n";
                    if (has_post_thumbnail()):
                        the_post_thumbnail('large', ['style' => 'max-width:100%; height:auto']);
                    endif;

                    if (is_single()): ?>
                    
                    <span>

                        <p class="post-meta meta singular-post-meta">
                        <?php echo '<a href="'.$authorlink.'">'.$authorname.'</a>' ?> | 
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                        </svg>   
                            <time class="dt-published" datetime="<?php the_date('Y-m-d H:i:s'); ?>" title="<?php echo get_the_date('Y-m-d H:i:s'); ?>"><?php echo get_the_date(); ?></time>
                        </p>
                    </span>
                    <?php endif;
                    

                    the_content(sprintf('Continue reading %s', the_title( '<span class="screen-reader-text">', '</span>', false)));
                    echo "\n</div>\n";


                
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