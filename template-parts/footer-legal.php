<div class="desktop-mt50">
    <div class="container">
        <div class="row legal-row">

                <div class="legal-copyright-section">
                    <p><?php echo do_shortcode( get_theme_mod('copyright_text') ); ?></p>
                </div>

                <div class="legal-menu-section">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu',
                            'menu_class' => 'footermenu'
                        )
                    );
                    ?>
                </div>

        </div>
    </div>
</div>
