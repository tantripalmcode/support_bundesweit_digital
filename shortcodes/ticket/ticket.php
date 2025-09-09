<?php

/*
Shortcodes für Body - Seitentitel und Jobs
*/

function ticket_sc( ){
    ?>


    <div class="ticket-wrapper">

        <div class="ticket-image">


            <?php if(has_post_thumbnail()):?>
                    <img src="<?php the_post_thumbnail_url('blog-small');?>" alt="<?php the_title();?>" class="single-post-image">
            <?php endif;?>

        </div>
        <div class="ticket-title">

            <h1><?php the_title(); ?></h1>


        </div>
        <div class="ticket-info">

            	<p > <?php echo get_post_meta( get_the_ID(), '_buditickets_meta_value_key', true ); ?></p>


        </div>




    </div>

    <style>

        .wpb_content_element{
            margin-bottom: 0px;
        }
    </style>
<?php
}
add_shortcode( 'page_ticket', 'ticket_sc' );
