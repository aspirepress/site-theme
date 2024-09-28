<?php
//------------------------------------------------------------------------------------------------
// Hooks
add_theme_support( 'post-thumbnails' );

add_theme_support( 'custom-logo');

add_action('wp_enqueue_scripts', function () {
    // Styles
    $dependencies = [
        'bootstrap' => '/vendordir/css/bootstrap.min.css',
    ];
    foreach ($dependencies as $name => $path) {
        wp_register_style($name, get_template_directory_uri() . $path, [], '3.37');
    }
    wp_enqueue_style('akrabat3-style', get_stylesheet_uri(), array_keys($dependencies));

    // Scripts
    $dependencies = ['jquery'];
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/vendordir/js/bootstrap.min.js', ['jquery'], '3.3.7', true);
    wp_enqueue_script('akrabat3-script', get_template_directory_uri().'/script.js', ['bootstrap'], '1.0.0', true);
});

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links'); // RSS feed links to <head>
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list']); // HTML 5 markup
    add_theme_support('post-formats', ['aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video']);
});


add_action('init', function () {
    register_nav_menu('header-menu', __('Header Menu'));
});

add_action('init', function () {
    register_nav_menu('footer-menu', __('Footer Menu'));
});

add_action('widgets_init', function () {
    register_sidebar([
        'name'          => 'Sidebar - First',
        'id'            => 'sidebar-1',
        'before_widget' => '<div class="sidebar-module">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => 'Sidebar - Second (inset)',
        'id'            => 'sidebar-2',
        'before_widget' => '<div class="sidebar-module sidebar-module-inset">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => 'Sidebar - Third',
        'id'            => 'sidebar-3',
        'before_widget' => '<div class="sidebar-module">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);
});

// advanced search functionality
add_action('pre_get_posts', function ($query) {
    if ($query->is_search()) {
        if (isset($_GET['post_type']) && !empty($_GET['post_type'])) {
            $query->set('post_type', $_GET['post_type']);
        }
    }
    return $query;
}, 1000);


add_filter('wp_title', function ($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep Page " . (string)max($paged, $page);
    }

    return $title;
});

add_filter(
    'excerpt_more',
    function ($more) {
        $post = get_post();
        return '… <a href="'. get_permalink($post->ID) . '">continue reading</a>.';
        // return ' <a href="'. get_permalink($post->ID) . '">...</a>';
        // return '…';
    },
    21
);

add_filter(
    'excerpt_length',
    function ($length) {
        return 75;
    },
    999
);

// add_filter(
//     'the_excerpt',
//     function ($excerpt) {
//         $post = get_post();
//         $excerpt .= ' <a href="'. get_permalink($post->ID) . '">continue reading</a>.';
//         return $excerpt;
//     },
//     21
// );



//------------------------------------------------------------------------------------------------
// Functions used in templates

function akrabat3_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
?>
    <li <?php comment_class('row'); ?> id="comment-<?php comment_ID() ?>">
        <div class="comment-author vcard meta">
            <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
            <cite>
                <?php echo get_comment_author_link(); ?>
            </cite>
        </div>
        
        <div class="col-sm-11">
        <?php if ($comment->comment_approved == '0') : ?>
            <em>Your comment is awaiting moderation.</em>
            <br />
        <?php endif; ?>
            <?php comment_text() ?>
            <div class="comment-meta meta">
                <a class="comment-link" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                    <?php echo get_comment_date(); ?> at <?php echo get_comment_time(); ?>
                </a>
                <?php edit_comment_link(__('(Edit)'),'  ','') ?>
            </div>

            <div class="reply">
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>
        </div>
<?php
}

function akrabat3_post_nav()
{
    global $post;

    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <nav class="navigation post-navigation row" role="navigation">
        <h1 class="screen-reader-text">Post navigation</h1>
        <div class="nav-links">
            <div class="col-sm-6">
            <?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link' ) ); ?>
            </div>
            <div class="col-sm-6 text-right">
            <?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link' ) ); ?>
            </div>

        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}

/**
 * Retrieve the HTML embed code, the time when it expires & its aspect ratio for a Notist presentation
 *
 * @param string $username       Notist username
 * @param string $notist_code    Notist code for this presentation
 * @return [string, int, float]  Array containing embed code and expiry (unix time) & aspect ratio
 */
function get_notist_embed_html(string $username, string $notist_code): array
{
    set_error_handler(
        function ($severity, $message, $file, $line) {
            throw new ErrorException($message, $severity, $severity, $file, $line);
        }
    );

    try {
        $url         = "https://noti.st/api/oembed?url=https://noti.st/$username/$notist_code";
        $string_data = file_get_contents($url);
        if ($string_data === false) {
            return ['', 0, 0];
        }
    } catch (Exception $e) {
        return ['', 0, 0];
    }

    restore_error_handler();

    $data = json_decode($string_data, true);
    if (!is_array($data)) {
        return ['', 0, 0];
    }

    $thumbnail_height = (int) $data['thumbnail_height'] ?? 0;
    if (isset($data['html']) && $thumbnail_height > 0) {
        $cache_age = $date['cache_age'] ?? 604800; // 7 days
        $aspect_ratio = ($data['thumbnail_width'] ?? 16) / ($data['thumbnail_height'] ?? 9);
        return [
            $data['html'],
            time() + $cache_age,
            $aspect_ratio,
        ];
    }

    return ['', 0, 0];
}

/**
 * Find aspect ratio of a Notist slide deck
 */
function get_notist_aspect_ratio(string $username, string $notist_code): string
{
    $url  = "https://noti.st/$username/$notist_code.json";
    $string_data = file_get_contents($url);
    if ($string_data === false) {
        return '';
    }

    $data = json_decode($string_data, true);
    if (!is_array($data)) {
        return '';
    }

    $imgUrl = $data['data'][0]['attributes']['slidedeck']['data'][0]['slides'][0]['image'] ?? null;
    if ($imgUrl) {
        $size = getimagesize($imgUrl);
        if (is_array($size)) {
            $width  = $size[0] ?? null;
            $height = $size[1] ?? null;
            if ($width && $height) {
                $ratio = number_format($width / $height, 3);
                switch ($ratio) {
                    case '1.333':
                        return '4:3';
                    case '1.778':
                        return '16:9';
                }
            }
        }
    }

    return '';
}

/**
 * robots.txt
 */
add_filter( 'robots_txt', function( $output, $public ) {
	if ( '0' == $public ) {
		$output = "User-agent: *\nDisallow: /\nDisallow: /*\nDisallow: /*?\n";
	} else {
        $site_url = parse_url( site_url() );
		$path = (!empty($site_url['path'])) ? $site_url['path'] : '';

        $output = <<<EOT
        User-agent: *
        Disallow: /wp-admin/
        Disallow: $path/wp-login.php

        
        User-agent: GPTBot
        Disallow: /
        
        Sitemap: {$site_url['scheme']}://{$site_url[ 'host' ]}/wp-sitemap.xml

        EOT;

	}

	return $output;

}, 99, 2 );  // Priority 99, Number of Arguments 2.
