<?php
    $aboute_img = get_field('aboute_img');
    $aboute_title = get_field('aboute_title');
    $aboute_desc = get_field('aboute_desc');
?>
<div class="section" id="aboute">
    <div class="container-center">
        <div class="section__item">
            <div class="section__item-container">
                <div class="aboute-me">
                    <div class="aboute-me__img">
                        <img src="<?= $aboute_img ?>" alt="Me">
                    </div>
                    <div class="aboute-me__content">
                        <div class="aboute-me__title">
                            <?= $aboute_title ?>
                        </div>
                        <div class="aboute-me__desc">
                            <?= $aboute_desc ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
