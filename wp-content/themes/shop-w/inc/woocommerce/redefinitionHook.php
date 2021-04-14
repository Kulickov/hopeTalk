<?php

    // Кастомная кнопка добавить в корзину, на странице товара.
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    add_action( 'woocommerce_single_product_summary', 'customAddToCart', 30 );

    function customAddToCart() {
        ob_start();
        global $product;
        ?>
        <?php if (!$product->is_in_stock()) { ?>
            <div class="block-not-in-stock">Скоро в продаже</div>
        <?php } else { ?>
            <div class="product__btn">
                <a class="btn btn_add button product_type_simple add_to_cart_button ajax_add_to_cart added" data-quantity="1" data-product_id="<?= get_the_ID() ?>" href="<?= do_shortcode('[add_to_cart_url id="' . get_the_ID() . '"]'); ?>"><?=$product->regular_price == '0' ? 'Получить' : 'Купить'?></a>
            </div>
        <?php } ?>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    add_filter( 'woocommerce_product_single_add_to_cart_text', 'tb_woo_custom_cart_button_text' );
    add_filter( 'woocommerce_product_add_to_cart_text', 'tb_woo_custom_cart_button_text' );
    function tb_woo_custom_cart_button_text() {
        global $product;
        return __( $product->is_in_stock() ? 'Купить' : 'Подробнее', 'woocommerce' );
    }

    // Отключаем комментарии к товарам.
    add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
    function sb_woo_remove_reviews_tab($tabs) {
        unset($tabs['reviews']);
        return $tabs;
    }

    // Отключаем стандартное описание.
    add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_description_tab', 98);
    function sb_woo_remove_description_tab($desc) {
        unset($desc['description']);
        return $desc;
    }

    // Отключаем похожие товары.
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

    //КАРТОЧКА ТОВАРА
    //Добавляем свое описание товара
    add_action( 'woocommerce_before_single_product_summary', 'add_right_wrapp_product', 20);
    function add_right_wrapp_product() {
        echo '<div class="single-product__right">';
    }
    add_action( 'woocommerce_after_single_product_summary', 'add_description_product', 20);
    function add_description_product() {
        $content = get_the_content();
        echo '<div class="single-product__description">' . $content . '</div></div>';
    }

    add_action('woocommerce_before_single_product', 'single_product_before_wrapp');
    function single_product_before_wrapp() {
        echo '<div class="single-product__wrapper">';
    }

    add_action('woocommerce_after_single_product', 'single_product_after_wrapp');
    function single_product_after_wrapp() {
        echo '</div>';
    }

    // Магазин loop
    add_filter( 'woocommerce_before_shop_loop_item', 'before_shop_image');
    function before_shop_image() {
        echo '<div class="product-grid__item-image">';
    }
    add_filter( 'woocommerce_before_shop_loop_item_title', 'after_shop_image');
    function after_shop_image() {
        echo '</div><div class="product-grid__item-bottom">';
    }
    add_filter( 'woocommerce_after_shop_loop_item', 'after_shop_item');
    function after_shop_item() {
        echo '</div>';
    }

    // Оформление заказа
    add_filter( 'woocommerce_checkout_fields', 'new_woocommerce_checkout_fields', 10, 1 );

    // Удаляем не лишние поля оформления заказа.
    function new_woocommerce_checkout_fields($fields){
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_state']);
        unset($fields['billing']['billing_country']);
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_phone']);
        unset($fields['billing']['billing_last_name']);

        return $fields;
    }

    // Отключаем купоны
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

    // Создаем обертку формы
    add_filter( 'woocommerce_before_checkout_form', 'before_checkout_wrapp');
    function before_checkout_wrapp() {
        echo '<div class="custom-chekout">';
    }

    add_filter( 'woocommerce_after_checkout_form', 'after_checkout_wrapp');
    function after_checkout_wrapp() {
        echo '</div>';
    }

    // Корзина

    // Создаем обертку корзины
    add_filter( 'woocommerce_before_cart', 'before_cart_wrapp' );
    function before_cart_wrapp() {
        echo '<div class="custom-cart">';
    }
    add_filter( 'woocommerce_after_cart', 'after_cart_wrapp' );
    function after_cart_wrapp() {
        echo '</div>';
    }

    // Если корзина пуста, редиректим на главную
    add_action( 'template_redirect', 'empty_cart_redirection' );
    function empty_cart_redirection(){
        if( is_cart() ) :

            // Here set the Url redirection
            $url_redirection = '/';
            // When trying to access cart page if cart is already empty
            if( WC()->cart->is_empty() ){
                wp_safe_redirect( $url_redirection );
                exit();
            }

            // When emptying cart on cart page
            wc_enqueue_js( "jQuery(function($){
                $(document.body).on( 'wc_cart_emptied', function(){
                    if ( $( '.woocommerce-cart-form' ).length === 0 ) {
                        $(window.location).attr('href', '" . $url_redirection . "');
                        return;
                    }
                });
            });" );
        endif;
    }

    // Меняем ссылку "Вернуться в магазин"
    add_filter( 'gettext', 'change_woocommerce_return_to_shop_text', 20, 3 );
    function change_woocommerce_return_to_shop_text( $translated_text, $text, $domain ) {
        switch ( $translated_text ) {
            case 'Вернуться в магазин' :
            $translated_text = __( 'Вернуться на Главную', 'woocommerce' );
            break;
            case 'Обновить корзину' :
            $translated_text = __( 'Обновить', 'woocommerce' );
            break;
        }
        return $translated_text;
    }

    add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );
    function wc_empty_cart_redirect_url() {
        return home_url();
    }

    // Меняем знак валюты ₽ на руб.
    add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

    function change_existing_currency_symbol( $currency_symbol, $currency ) {
        switch( $currency ) {
            case 'RUB': $currency_symbol = 'руб.'; break;
        }
        return $currency_symbol;
    }
?>
