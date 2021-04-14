<?php

    // Подключаем woocommerce
    add_action( 'after_setup_theme', 'woocommerce_support' );
    function woocommerce_support() {
        add_theme_support( 'woocommerce' );
        // add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    }

    // Показываем колличество товаров в корзине, после добавления товара.
    add_filter('woocommerce_add_to_cart_fragments', 'header_add_to_cart_fragment');

    function header_add_to_cart_fragment( $fragments ) {
        global $woocommerce;
        $counter = WC()->cart->get_cart_contents_count();
        $cart_url = '/cart/';
        ob_start();
        ?>
        <?php if ($counter != '0') { ?>
            <a href="<?= wc_get_cart_url() ?>" class="header__cart-wrapp">
                <img class="header__cart-img" src="<?= VG_IMG . 'cart.svg' ?>" alt="cart">
                <span class="header__cart-counter show"><?= $counter ?></span>
            </a>
        <?php } else { ?>
            <div class="header__cart-wrapp empty">
                <img class="header__cart-img" src="<?= VG_IMG . 'cart.svg' ?>" alt="cart">
                <span class="header__cart-counter"><?= $counter ?></span>
                <div class="header__cart-empty">
                    Ваша корзина пуста.
                </div>
            </div>
            <?php
                exit(header("Location: /index.php"));
             ?>
        <?php } ?>
        <?php
        $fragments['.header__cart-wrapp'] = ob_get_clean();
        return $fragments;
    }

 ?>
