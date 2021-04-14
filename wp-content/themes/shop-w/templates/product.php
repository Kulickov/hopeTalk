<div class="product-custom-grid">
    <?php
    $counter = 0;
    $product_arr = [];
    $metaQueryArg = ['relation' => 'AND'];
    $args = array(
        'post_type' => 'product',
        'meta_query' => [
            $metaQueryArg
            ],
            'posts_per_page' => '3'
        );
        $query = new WP_Query($args);
        while ( $query->have_posts() ) {
            $query->the_post();
            $counter++;
            $price = get_post_meta( get_the_ID(), '_regular_price', true);
            $product_availability = get_field('product_availability');
            ?>
            <?php if ($counter == 1) {
                    ob_start();
                 ?>
                 <a href="<?= the_permalink() ?>" class="<?= $product->is_in_stock() ? 'product-custom-grid__item' : 'product-custom-grid__item product-custom-grid__item_disabled'?>">
                     <div class="<?= $product->is_in_stock() ? 'product__img' : 'product__img product__img_monochrome'?>"  style="background-image: url('<?= the_post_thumbnail_url() ?>')"></div>
                     <div class="<?= $product->is_in_stock() ? 'product__overlay' : 'product__overlay product__overlay_full'?>">
                         <div class="product__name">
                             <?= the_title() ?>
                         </div>
                         <div class="product__price">
                             <?php if ($product->is_in_stock()) { ?>
                                 <div class="product__overlay-bottom">
                                     <span class="product__price-sum"><?= $price ?> руб.</span>
                                     <span class="product__price-txt">Получить</span>
                                 </div>
                             <?php } else { ?>
                                 <?php if ($product_availability) { ?>
                                      <span class="product__price-txt"><?= $product_availability ?></span>
                                 <?php } else { ?>
                                 <span class="product__price-txt">Скоро в продаже</span>
                             <?php } ?>
                             <?php } ?>
                         </div>
                     </div>
                 </a>
            <?php
            $product_1 = ob_get_contents();
            ob_end_clean();
            } else {
                ob_start();
                ?>
                <a href="<?= the_permalink() ?>" class="<?= $product->is_in_stock() ? 'product-custom-grid__item' : 'product-custom-grid__item product-custom-grid__item_disabled'?>">
                    <div class="<?= $product->is_in_stock() ? 'product__img' : 'product__img product__img_monochrome'?>"  style="background-image: url('<?= the_post_thumbnail_url() ?>')"></div>
                    <div class="<?= $product->is_in_stock() ? 'product__overlay' : 'product__overlay product__overlay_full'?>">
                        <div class="product__name">
                            <?= the_title() ?>
                        </div>
                        <div class="product__price">
                            <?php if ($product->is_in_stock()) { ?>
                                <div class="product__overlay-bottom">
                                    <span class="product__price-sum"><?= $price ?> руб.</span>
                                    <span class="product__price-txt">Получить</span>
                                </div>
                            <?php } else { ?>
                                <?php if ($product_availability) { ?>
                                     <span class="product__price-txt"><?= $product_availability ?></span>
                                <?php } else { ?>
                                <span class="product__price-txt">Скоро в продаже</span>
                            <?php } ?>
                        <?php } ?>
                        </div>
                    </div>
                </a>
            <?php
            array_push($product_arr, ob_get_contents());
            ob_end_clean();
                } ?>
        <?php } ?>
        <?php wp_reset_query() ?>
        <div class="product-custom-grid__left">
            <?= $product_1 ?>
        </div>
        <div class="product-custom-grid__right">
            <?php foreach ($product_arr as $value): ?>
                <?= $value ?>
            <?php endforeach; ?>
        </div>
    </div>
