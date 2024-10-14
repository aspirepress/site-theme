      </div><!-- /.row -->

    <footer class="blog-footer row">
    <?php //dynamic_sidebar( 'footer-copyright-text' ); ?>
    <?php //if ( is_active_sidebar( 'footer-copyright-text' ) ) { dynamic_sidebar( 'footer-copyright-text' ); } ?>

        <div class="footer">
        <ul id="footer-menu" class=" list-inline">
        <?php
        wp_nav_menu([
            'theme_location' => 'footer-menu',
            'menu_class' => 'list-inline',
            'menu_id' => 'footer-menu',
            'container' => false,
        ]);
        ?>
        </div>
        <div class="">
            <p class="copyright">Copyright &copy; <?php echo date('Y');?> AspirePress. Theme courtesy <a href="https://akrabat.com/">Rob Allen</a>. All rights reserved.</p>
        </div>
    </footer>

    </div><!-- /.container -->
    <?php wp_footer(); ?>
  </body>
</html>
