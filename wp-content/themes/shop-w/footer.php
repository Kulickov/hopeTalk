        </main>
            <footer class="<?= is_front_page() ? 'footer footer_fixed' : 'footer' ?>">
                <div class="container-center">
                    <div class="footer__soc">
                        <a href="<?= get_field('link_instagram', 'option') ?>" target="_blank" class="footer__soc-item">
                            <img src="<?= VG_IMG . 'instagram.svg' ?>" alt="instagram">
                        </a>
                        <a href="<?= get_field('link_telegram', 'option') ?>" target="_blank" class="footer__soc-item">
                            <img src="<?= VG_IMG . 'telegram.svg' ?>" alt="telegram">
                        </a>
                    </div>
                    <div class="footer__nav">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            )
                        );
                        ?>
                    </div>
                </div>
            </footer>
    </body>
<?php wp_footer(); ?>
</html>
