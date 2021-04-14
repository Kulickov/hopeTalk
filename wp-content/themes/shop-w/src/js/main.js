// import 'pagepiling-js-version-kostyast/jquery.pagepiling.css';
import 'swiper/swiper-bundle.min.css';
import Swiper, { Navigation, Pagination } from 'swiper';
Swiper.use([Navigation, Pagination]);
import anime from 'animejs/lib/anime.es.js';
import pagepiling from 'pagepiling-js-version-kostyast';
import '../scss/main.scss';

jQuery(document).ready(function($) {
    if (window.location.pathname == '/' && document.body.clientWidth > 767) {
            $('#pagepiling').pagepiling({
                navigation: false,
                direction: 'vertical',
                anchors: ['product', 'aboute-me', 'testimonials'],
                menu: '#myMenu',
                afterLoad: function(anchorLink, index) {
                    if (anchorLink == 'testimonials') {
                        $('#arrow-scrool').addClass('hidden');
                        $('.footer_fixed').addClass('show');
                    } else {
                        $('#arrow-scrool').removeClass('hidden');
                        $('.footer_fixed').removeClass('show');
                    }
                }
            });

            $('body').addClass('no-scrool');
            let scrollDown = $('#arrow-scrool');
            scrollDown.on('click', function(event) {
                $.fn.pagepiling.moveSectionDown();
            });
        } else {
            $('body').addClass('show');
            $('.header').addClass('header_visible');
        }

        $(window).scroll(function(){
                 var $sections = $('.section');
        	$sections.each(function(i,el){
                var top  = $(el).offset().top-100;
                var bottom = top +$(el).height();
                var scroll = $(window).scrollTop();
                var id = $(el).attr('id');
            	if( scroll > top && scroll < bottom){
                    $('a.active').removeClass('active');
        			$('a[href="#'+id+'"]').addClass('active');

                }
            })
         });
});

let main = {
    init: function() {
        document.addEventListener('DOMContentLoaded', () => {
            this.testimonialSlider();
            this.burgerMenu();
            this.anchorMenu();
        });
    },

    testimonialSlider: () => {
        new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            spaceBetween: 30,
            autoHeight: true,
            loop: true
        });
    },

    burgerMenu: () => {
        const btn = document.getElementById('burger');
        const menu = document.getElementById('burger-menu');
        const close = document.getElementById('burger-close');

        if (!btn || !menu || !close) return;

        btn.onclick = () => {
            menu.classList.add('show');
            document.body.classList.add('no-scrool');
        }

        close.onclick = () => {
            menu.classList.remove('show');
            document.body.classList.remove('no-scrool');
        }
    },

    anchorMenu: () => {
        const menu = document.getElementById('burger-menu');
        document.querySelectorAll('.burger-menu__link').forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                menu.classList.remove('show');
                document.body.classList.remove('no-scrool');

                const target = document.querySelector(link.getAttribute('href'));

                anime({
                    targets: ['html', 'body'],
                    scrollTop: {
                        value: target.offsetTop - document.querySelector('header').getBoundingClientRect().height,
                        duration: 2000,
                        easing: 'easeOutExpo'
                    }
                });
            });
        });
    }
};

main.init();
