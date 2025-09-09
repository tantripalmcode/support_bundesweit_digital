<?php
/**
 * Voucher Motives Popup Template
 * 
 * This template displays a popup with voucher motives content
 * showing front and back images from ACF fields
 */

// Get all voucher motives posts
$voucher_motives = get_posts(array(
    'post_type' => 'voucher_motives',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

if (empty($voucher_motives)) {
    return; // Exit if no voucher motives found
}
?>

<div id="voucher-popup" class="voucher-popup-overlay" style="display: none;">
    <div class="voucher-popup-container">
        <div class="voucher-popup-content">
            <!-- Close button -->
            <button class="voucher-popup-close" type="button" aria-label="Close popup">
                <span>&times;</span>
            </button>
            
            
            <!-- Main content area with Swiper -->
            <div class="voucher-swiper-container">
                <div class="swiper voucher-swiper">
                    <div class="swiper-wrapper">
                        <!-- Slides will be populated by JavaScript -->
                    </div>
                </div>
                <!-- Navigation arrows -->
                <div class="swiper-button-next voucher-nav-next"></div>
                <div class="swiper-button-prev voucher-nav-prev"></div>
            </div>
            
            <!-- Category tabs - dynamically generated -->
            <div class="voucher-categories">
                <!-- Categories will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Hidden data for JavaScript -->
<script type="application/json" id="voucher-data">
<?php
$voucher_data = array();
foreach ($voucher_motives as $index => $voucher) {
    $front_image = get_field('front_image', $voucher->ID);
    $front_image_url = wp_get_attachment_image_src($front_image, 'full');
    $back_image = get_field('back_image', $voucher->ID);
    $back_image_url = wp_get_attachment_image_src($back_image, 'full');
    
    $voucher_data[] = array(
        'post_id' => $voucher->ID,
        'post_title' => $voucher->post_title,
        'front_image' => $front_image ? $front_image_url[0] : '',
        'back_image' => $back_image ? $back_image_url[0] : ''
    );
}
echo json_encode($voucher_data);
?>
</script>
