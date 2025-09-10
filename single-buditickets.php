<?php

/**
 * Template for displaying single buditickets posts
 * Custom password protected page for buditickets CPT
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php if (post_password_required()) : ?>
        <!-- Password Protected Content -->
        <div class="ticket-wrapper">
            <div class="ticket-image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large'); ?>
                <?php else : ?>
                    <div class="lock-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8H17V6C17 3.24 14.76 1 12 1S7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM12 17C10.9 17 10 16.1 10 15S10.9 13 12 13S14 13.9 14 15S13.1 17 12 17ZM15.1 8H8.9V6C8.9 4.29 10.29 2.9 12 2.9S15.1 4.29 15.1 6V8Z" fill="#0B3753" />
                        </svg>
                    </div>
                <?php endif; ?>
            </div>

            <div class="ticket-title">
                <h1><?php echo esc_html(get_post_field('post_title', get_the_ID())); ?></h1>
            </div>

            <div class="ticket-info">
                <div class="password-form-container">
                    <?php
                    $form_title = get_field('form_title');

                    if ($form_title) {
                        echo sprintf('<h2 class="password-form-title">%s</h2>', $form_title);
                    } else {
                        echo sprintf('<h2 class="password-form-title">%s</h2>', __('Jetzt einloggen', 'budigital-child'));
                    }
                    ?>


                    <?php
                    // Display the password form
                    $label = 'pwbox-' . get_the_ID();
                    $form = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
                                    <div class="password-form">
                                        <label for="' . $label . '" class="password-form-label sr-only">' . __("Password:", 'budigital-child') . '</label>
                                        <input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" placeholder="' . __("Passwort *", 'budigital-child') . '" />
                                        <input type="submit" name="Submit" value="' . esc_attr__("Einloggen", 'budigital-child') . '" class="password-submit" />
                                    </div>
                                </form>';

                    echo $form;
                    ?>
                </div>
            </div>
        </div>

    <?php else : ?>

        <?php the_content(); ?>

    <?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>