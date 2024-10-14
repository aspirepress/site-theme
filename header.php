<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<link href="https://fonts.googleapis.com/css?family=Lato:300|PT+Serif:400,400i,700,700i" rel="stylesheet">

</head>

<body <?php body_class(); ?>>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-365662-1', 'auto');
	ga('send', 'pageview');
</script>

<div class="blog-masthead">
	<div class="container-fluid">
		<div class="blog-header">
		<?php
		$custom_logo_id  = get_theme_mod( 'custom_logo' );
		$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		if ( $custom_logo_url ) {
			echo '<div><a href="/"><img style="display: block; clear: both; margin: 0px auto; border: none" src="' . esc_url( $custom_logo_url ) . '" alt="logo"></a></div>';
		}
		?>
		<div style="text-align: center">
			<!---<div class="h1 blog-title"><a href="/"><?php bloginfo( 'name' ); ?></a></div>-->
			<?php $description = get_bloginfo( 'description', 'display' ); ?>
			<?php if ( $description ) : ?>
			<p class="lead blog-description"><?php echo esc_html( $description ); ?></p>
			<?php endif ?>
		</div>
		<div class="nav-menu" style="text-align: center">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'header-menu',
				'menu_class'     => 'blog-nav list-inline',
				'container'      => false,
			)
		);
		?>
		</div>
	</div>
</div>
</div>
<div class="container-fluid">


	<div class="row">
