</div><!-- /.row -->

	<footer class="blog-footer row">

		<div class="footer">
		<ul id="footer-menu" class=" list-inline">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer-menu',
				'menu_class'     => 'list-inline',
				'menu_id'        => 'footer-menu',
				'container'      => false,
			)
		);
		?>
		</div>
		<div class="">
			<p class="copyright">Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> AspirePress. Theme courtesy <a href="https://akrabat.com/">Rob Allen</a>. All rights reserved.</p>
		</div>
	</footer>

	</div><!-- /.container -->
	<?php wp_footer(); ?>
	</body>
</html>
