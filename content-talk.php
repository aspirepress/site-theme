            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>


                <?php
                $postId = get_the_ID();
                $event = trim(get_post_meta($postId, 'talk_event', true));
                $event_date = trim(get_post_meta($postId, 'talk_date', true));
                $event_text = '';
                if ($event) {
                    if ($event_date) {
                        $event .= ", $event_date";
                    }
                    $event = esc_html($event);
                    $event_text = "<small>Presented at $event</small>";
                }

                if (is_singular()) :
                    the_title(
                        '<h1 class="post-title page-header talk-title">',
                        "$event_text</h1>"
                    );
                else :
                    the_title(
                        sprintf('<h2 class="post-title talk-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                        "</a>$event_text</h2>"
                    );
                endif;
                ?>
                <div class="entry-summary">
                    <?php the_content(sprintf('Continue reading %s', the_title( '<span class="screen-reader-text">', '</span>', false))); ?>
                </div>

                <?php
                global $akrabat_talk_type_fields, $akrabat_talk_type_textareas;

                $links = [];

                $notist_code = trim(get_post_meta($postId, 'talk_code_notist', true));
                $notist_url = 'https://speaking.akrabat.com';
                if ($notist_code) {
                    $links[] = '<a href="' . $notist_url . '/' . $notist_code . '">Notist</a>';
                }

                foreach ($akrabat_talk_type_fields as $key => $label) {
                    if (stripos($label, 'URL') == false) {
                        continue;
                    }
                    $label = str_replace(' URL', '', $label);
                    $value = trim(get_post_meta($postId, $key, true));
                    if (empty($value)) {
                        continue;
                    }
                    if (stripos($value, 'joind.in') !== false) {
                        $label = 'Joind.in';
                    }
                    
                    $links[] = '<a href="' . $value .'">' . $label . '</a></li>';
                }

                if (!is_singular()) {
                    // displaying on a list page

                    // add link for Speakerdeck
                    $speakerdeck_url = trim(get_post_meta($postId, 'talk_url_speakerdeck', true));
                    if ($speakerdeck_url) {
                        $site = 'Slides';
                        if (stripos($speakerdeck_url, 'speakerdeck') !== false) {
                            $site = 'Speaker Deck';
                        } elseif (stripos($speakerdeck_url, 'noti.st') !== false) {
                            $site = 'Notist';
                        } elseif (stripos($speakerdeck_url, 'speaking.akrabat.com') !== false) {
                            $site = 'Notist';
                        }
                        $links[] = '<a href="' . $speakerdeck_url . '">' . $site . '</a>';
                    }
                    // add link for Youtube
                    $youtube_id = trim(get_post_meta($postId, 'talk_youtube_id', true));
                    if ($youtube_id) {
                        $links[] = '<a href="https://www.youtube.com/watch?v=' . $youtube_id . '">Video</a>';
                    }
                }

                $links = implode(" | ", $links);
                ?>
                <div class="talk-links">
                    <p><?= $links ?></p>
                </div>

                <?php
                if (is_singular()) {
                    $youtube_id = trim(get_post_meta($postId, 'talk_youtube_id', true));
                    if ($youtube_id) {
                        echo <<<HTML
                        <p>
                        <h4>Video</h4>
                        <div class="youtubevideowrap">
                        <div class="video-container">
                        <iframe width="853" height="480" src="https://www.youtube.com/embed/$youtube_id" frameborder="0" allowfullscreen></iframe>
                        </div>
                        </div>
                        </p>
HTML;
                    }
                        // <iframe width="560" height="315" src="https://www.youtube.com/embed/$youtube_id" frameborder="0" allowfullscreen></iframe>
        
                    $video_embed = trim(get_post_meta($postId, 'talk_embed_video', true));
                    if ($video_embed) {
                        echo <<<HTML
                        <p>
                        <h4>Video</h4>
                        $video_embed
                        </p>
HTML;
                    }

                    // Embed notist slides if we have a Notist code
                    if ($notist_code)  {
                        // $notist_code = 'JwEI4m';
                        $title = get_the_title($postId);
                        $notist_username = 'akrabat';

                        $notist_embed_html = get_post_meta($postId, 'talk_notist_embed_html', true);
                        $notist_embed_expires = get_post_meta($postId, 'talk_notist_embed_expires', true);
                        $notist_embed_aspect = get_post_meta($postId, 'talk_notist_embed_aspect', true);

                        if (empty($notist_embed_html) || time() > $notist_embed_expires) {
                            // No embed HTML or it's expired: get new embed HTML.
                            $info = get_notist_embed_html($notist_username, $notist_code);

                            list($notist_embed_html, $notist_embed_expires, $notist_embed_aspect) = $info;
                            if ($notist_embed_html) {
                                update_post_meta($postId, 'talk_notist_embed_html', $notist_embed_html);
                                update_post_meta($postId, 'talk_notist_embed_expires', $notist_embed_expires);
                                update_post_meta($postId, 'talk_notist_embed_aspect', $notist_embed_aspect);
                            }
                        }

if ($notist_embed_html) {
    $notist_embed_html = htmlentities($notist_embed_html);
    $percentage        = 100.0 / $notist_embed_aspect;
    echo <<<HTML
<h4>Slides</h4>
<div style="position: relative; overflow: hidden; padding-top: $percentage%;">
    <iframe sandbox="allow-scripts" scrolling="no" frameborder="0"
        style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"
        srcdoc="$notist_embed_html"></iframe>
</div>
HTML;
}
                    } else {
                        $slides_embed = trim(get_post_meta($postId, 'talk_embed_slides', true));
                        if ($slides_embed) {
                            echo <<<HTML

                            <h4>Slides</h4>
                            $slides_embed

HTML;
                        }
                    }
                }
                ?>

                <?php if (is_singular()) : ?>
                <p class="post-meta meta list-post-meta" style="margin-top: 20px;">
                    <?php edit_post_link('<span>Edit page</span>', '<span class="edit-link"> ', '</span>'); ?>
                </p>
                <?php endif; ?>
            </article>


