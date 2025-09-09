<div class="masterhead">
    <div class="container">
        <div class="container-inner">
            <div class="branding col-sm-4">
                <a href="/">
                    <?php if( get_theme_mod('company_logo') != "" ): ?>
                        <img class="logo" src="<?php echo get_theme_mod('company_logo'); ?>" />
                    <?php endif; ?>
                </a>
            </div>

            <div class="main col-sm-8">

                <div class="top-bar">

                    <li class="job">
                        <?php
                        if( get_theme_mod('cta1_text') ){
                            $link_url = get_theme_mod('cta1_url');
                            $link_title = get_theme_mod('cta1_text');
                            $link_target = get_theme_mod('cta1_target');
                            ?>
                            <a class="button plain" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo ( $link_title ); ?></a>
                        <?php } ?>
                    </li>

                    <li class="mail-white">
                        <?php
                        if( get_theme_mod('cta2_text') ){
                            $link_url = get_theme_mod('cta2_url');
                            $link_title = get_theme_mod('cta2_text');
                            $link_target = get_theme_mod('cta2_target');
                            ?>
                            <a class="button ss" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo ( $link_title ); ?></a>
                        <?php } ?>
                    </li>

                    <div class="clear clearfix"></div>
                </div>

            </div> <!-- col 10 -->
        </div> <!-- .container-inner -->
    </div>

</div>
<?php

?>
