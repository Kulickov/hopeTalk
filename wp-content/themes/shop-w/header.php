<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="icon" type="image/x-icon" href="/favicon.svg">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>  >
        <header class="<?= is_front_page() ? 'header' : 'header header_visible' ?>">
            <div class="container-center">
                <div class="header__container">
                    <a href="/" class="header__logo">
                        <img src="<?= VG_IMG . 'logo.svg' ?>" alt="hopeTalk">
                    </a>
                    <?php if (is_front_page()) {
                        include 'templates/burger.php';
                    } ?>
                    <div class="header__cart">
                        <?php
                        global $woocommerce;
                        ?>
                        <div class="header__cart-wrapp empty">
                            <img class="header__cart-img" src="<?= VG_IMG . 'cart.svg' ?>" alt="cart">
                            <span class="header__cart-counter"><?= WC()->cart->get_cart_contents_count() ?></span>
                            <div class="header__cart-empty">
                                Ваша корзина пуста.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (is_front_page()) {
                include 'templates/burgerMenu.php';
            } ?>
        </header>
        <main id='page-main'class="<?= is_front_page() ? 'main' : 'main main_margin' ?>">
