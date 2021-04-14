<?php
/* Template Name: page */
get_header();
$mainContent = get_the_content();
?>
    <div class="container-center">

        <?php if ($mainContent) { ?>
            <?php echo apply_filters('the_content', $mainContent); ?>
        <?php } ?>
    </div>

<?php
get_footer();
