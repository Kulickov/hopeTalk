<?php
function woo_catalog_orderby( $orderby ) {
    unset($orderby["price"]); // Сортировка по цене по возрастанию
    unset($orderby["price-desc"]); // Сортировка по цене по убыванию
    unset($orderby["popularity"]); // Сортировка по популярности
    unset($orderby["rating"]); // Сортировка по рейтингу
    unset($orderby["date"]);    // Сортировка по дате
    unset($orderby["title"]);	 // Сортировка по названию
    unset($orderby["menu_order"]); // Сортировка по умолчанию (можно определить порядок в админ панели)
    return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "woo_catalog_orderby", 20 );

// По каким критериям мы будем осуществлять нашу сортировку
add_filter( 'woocommerce_get_catalog_ordering_args', 'woocommerce_get_catalog_ordering_name_args' );

function woocommerce_get_catalog_ordering_name_args( $args ) {
    if (isset($_GET['orderby'])) {
        switch ($_GET['orderby']) :
            case 'name_list_asc' :
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
                $args['meta_key'] = '';
            break;
            case 'name_list_desc' :
                $args['orderby'] = 'title';
                $args['order'] = 'DESC';
                $args['meta_key'] = '';
            break;
        endswitch;
    }

	return $args;
}
// Добавляем условия в стандартный вывод сортировки WP (выпадающий список)
function woocommerce_catalog_name_orderby( $sortby ) {
    $sortby['name_list_asc'] = 'По алфавиту A-Z';
    $sortby['name_list_desc'] = 'По алфавиту Z-A';
	return $sortby;
}
add_filter( 'woocommerce_catalog_orderby', 'woocommerce_catalog_name_orderby', 1 );

function woocommerce_get_catalog_ordering_popular_args( $args ) {
    global $wp_query;
    if (isset($_GET['orderby'])) {
        switch ($_GET['orderby']) :
            case 'popularity_asc' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'ASC';
                $args['meta_key'] = 'total_sales';
            break;
            case 'popularity_desc' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC';
                $args['meta_key'] = 'total_sales';
            break;
        endswitch;
    }

	return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'woocommerce_get_catalog_ordering_popular_args' );
// Добавляем условия в стандартный вывод сортировки WP (выпадающий список)
function woocommerce_catalog_popular_orderby( $sortby ) {
    $sortby['popularity_asc'] = 'По популярности z-a';
    $sortby['popularity_desc'] = 'По популярности a-z';
	return $sortby;
}
add_filter( 'woocommerce_catalog_orderby', 'woocommerce_catalog_popular_orderby', 1 );
?>
