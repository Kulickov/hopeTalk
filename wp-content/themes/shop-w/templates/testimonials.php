<?php
    $testimonials_title = get_field('testimonials_title');
    $testimonials = get_field('testimonials');
?>
<div class="section" id="testimonials">
    <div class="container-center">
        <div class="section__item section__item_no-indentation">
            <div class="section__item-container">
                <div class="testimonials">
                    <div class="testimonials__title"><?= $testimonials_title ?></div>
                    <!-- Swiper -->
                    <div class="testimonials__slider">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?php if ($testimonials): ?>
                                    <?php foreach ($testimonials as $testimonial): ?>
                                        <div class="swiper-slide">
                                            <div class="testimonials__item">
                                                <?php if ($testimonial['testimonials_text']): ?>
                                                    <div class="testimonials__text">
                                                        <?= $testimonial['testimonials_text'] ?>
                                                    </div>
                                                    <div class="testimonials__bottom">
                                                        <div class="testimonials__bottom-content">
                                                            <div class="testimonials__bottom-text">
                                                                <div class="testimonials__author">
                                                                    <?= $testimonial['testimonials_author'] ?>
                                                                </div>
                                                                <div class="testimonials__niche">
                                                                    <?= $testimonial['testimonials_niche'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="testimonials__img">
                                                                <img src="<?= $testimonial['testimonials_photo'] ?>" alt="avatar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
