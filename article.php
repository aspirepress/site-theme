<?php
				$categories_list = explode( '§', get_the_category_list( '§' ) );
				$tag_list        = explode( '§', get_the_tag_list( '', '§' ) );
				$list            = $categories_list + $tag_list;
				$list            = implode( ', ', $list );
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post h-entry' ); ?>>
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="post-title page-header p-name">', '</h1>' );
				else :
					$search_type = '';
					if ( is_search() ) {
						$ap_post_type = get_post_type();
						if ( 'talk' === $ap_post_type ) {
							$search_type   = ucfirst( $ap_post_type );
							$custom_fields = get_post_custom();
							if ( ! empty( $custom_fields['talk_event'] ) ) {
								$search_type = current( $custom_fields['talk_event'] );
								$search_type = str_replace( 'user group', '', $search_type );
								$search_type = trim( $search_type );
							}
							if ( ! empty( $custom_fields['talk_date'] ) ) {
								$search_type .= ' ' . gmdate( 'Y', strtotime( current( $custom_fields['talk_date'] ) ) );
							}

							$search_type .= ': ';
						}
					}
					the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">' . $search_type, esc_url( get_permalink() ) ), '</a></h2>' );
				endif;
				?>

				<?php if ( is_search() ) : // Only display Excerpts for Search. ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
					<p class="post-meta meta list-post-meta">Posted on
							<?php the_date(); ?>
							in <span class="categories-links"><?php echo $list; ?></span>

						<?php
						if ( comments_open() && ! is_singular() ) :
							?>
							<span class="comments-link meta-segment">
								<?php comments_popup_link( '<span class="leave-reply">Leave a comment</span>', 'One comment so far', 'View all % comments' ); ?>
							</span>
						<?php endif; // comments_open() ?>

						<?php edit_post_link( '<span>Edit</span>', '<span class="edit-link meta-segment"> ', '</span>' ); ?>
					</p>
				</div>
				<?php elseif ( ! is_singular() ) : // Only display Excerpts list pages. ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
					<p class="post-meta meta list-post-meta">
						<span class="categories-links categories-pill">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-fill" viewBox="0 0 16 16">
						<path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3m-8.322.12q.322-.119.684-.12h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981z"/>
						</svg>    
						
						<?php echo esc_html( $list ); ?></span>  
						<?php echo get_the_date(); ?>
							

						<?php
						if ( comments_open() && ! is_singular() ) :
							?>
							<span class="comments-link meta-segment">
								<?php comments_popup_link( '<span class="leave-reply">Leave a comment</span>', 'One comment so far', 'View all % comments' ); ?>
							</span>
						<?php endif; // comments_open(). ?>

						<?php edit_post_link( '<span>Edit</span>', '<span class="edit-link meta-segment"> ', '</span>' ); ?>
					</p>
				</div>
					<?php
				else :
					// single post page.
					$author_id  = get_the_author_meta( 'ID' );
					$authorlink = get_the_author_meta( 'user_url', $author_id ) . '/author/' . get_the_author_meta( 'user_login', $author_id );
					$authorname = get_the_author_meta( 'display_name', $author_id );
					echo "<div class=\"e-content\">\n";
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'large', array( 'style' => 'max-width:100%; height:auto' ) );
					endif;

					if ( is_single() ) :
						?>
					
					<span>

						<p class="post-meta meta singular-post-meta">
						<?php echo '<a href="' . $authorlink . '">' . $authorname . '</a>'; ?> | 
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
							<path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
							<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
						</svg>   
							<time class="dt-published" datetime="<?php the_date( 'Y-m-d H:i:s' ); ?>" title="<?php echo get_the_date( 'Y-m-d H:i:s' ); ?>"><?php echo get_the_date(); ?></time>
						</p>
					</span>
						<?php
					endif;


					the_content( sprintf( 'Continue reading %s', the_title( '<span class="screen-reader-text">', '</span>', false ) ) );
					echo "\n</div>\n";



					wp_link_pages(
						array(
							'before'      => '<div class="page-links"><span class="page-links-title">Pages</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						)
					);


					if ( false && comments_open() && ! is_singular() ) :
						?>
						<div class="comments-link meta">
							<?php comments_popup_link( '<span class="leave-reply">Leave a comment</span>', 'One comment so far', 'View all % comments' ); ?>
						</div>
						<?php
					endif; // comments_open().
					?>
								<span class="categories-links">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-fill" viewBox="0 0 16 16">
						<path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3m-8.322.12q.322-.119.684-.12h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981z"/>
					</svg>
					<?php echo esc_html( $list ); ?>
					</span>
				<?php endif; ?>
			</article>
