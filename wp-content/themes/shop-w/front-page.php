<?php
    get_header();
    $mainContent = get_the_content();
 ?>
     <div class="layout">
         <div class="layout__wrapp">
             <div class="sidebar">
                 <ul class="sidebar__nav"id="myMenu">
                     <li class="sidebar__nav-item active" data-menuanchor="product">
                         <a class="sidebar__nav-link" href="#product">Продукты</a>
                     </li>
                     <li class="sidebar__nav-item" data-menuanchor="aboute-me">
                         <a class="sidebar__nav-link" href="#aboute-me">Обо мне</a>
                     </li>
                     <li class="sidebar__nav-item" data-menuanchor="testimonials">
                         <a class="sidebar__nav-link" href="#testimonials">Отзывы</a>
                     </li>
                 </ul>
             </div>
             <div class="page-arrow" id="arrow-scrool">
                 <img src="<?= VG_IMG . 'arrow.svg' ?>" alt="arrow">
             </div>
         </div>
     </div>
     <div class="section-wrapp__content" id="pagepiling">
         <div class="section" id="product">
             <div class="container-center">
                 <div class="section__item">
                     <div class="section__item-container">
                         <?php include 'templates/product.php'; ?>
                     </div>
                 </div>
             </div>
         </div>
        <?php include 'templates/abouteMe.php'; ?>
        <?php include 'templates/testimonials.php'; ?>
     </div>


<?php get_footer(); ?>
