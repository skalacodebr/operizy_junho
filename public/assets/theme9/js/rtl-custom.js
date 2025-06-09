!function (e) { e.fn.niceSelect = function (t) { function s(t) { t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class") || "").addClass(t.attr("disabled") ? "disabled" : "").attr("tabindex", t.attr("disabled") ? null : "0").html('<span class="current"></span><div class="list-wrp"><ul class="list"></ul></div>')); var s = t.next(), n = t.find("option"), i = t.find("option:selected"); s.find(".current").html(i.data("display") || i.text()), n.each(function (t) { var n = e(this), i = n.data("display"); s.find("ul").append(e("<li></li>").attr("data-value", n.val()).attr("data-display", i || null).addClass("option" + (n.is(":selected") ? " selected" : "") + (n.is(":disabled") ? " disabled" : "")).html(n.text())) }) } if ("string" == typeof t) return "update" == t ? this.each(function () { var t = e(this), n = e(this).next(".nice-select"), i = n.hasClass("open"); n.length && (n.remove(), s(t), i && t.next().trigger("click")) }) : "destroy" == t ? (this.each(function () { var t = e(this), s = e(this).next(".nice-select"); s.length && (s.remove(), t.css("display", "")) }), 0 == e(".nice-select").length && e(document).off(".nice_select")) : console.log('Method "' + t + '" does not exist.'), this; this.hide(), this.each(function () { var t = e(this); t.next().hasClass("nice-select") || s(t) }), e(document).off(".nice_select"), e(document).on("click.nice_select", ".nice-select", function (t) { var s = e(this); e(".nice-select").not(s).removeClass("open"), s.toggleClass("open"), s.hasClass("open") ? (s.find(".option"), s.find(".focus").removeClass("focus"), s.find(".selected").addClass("focus")) : s.focus() }), e(document).on("click.nice_select", function (t) { 0 === e(t.target).closest(".nice-select").length && e(".nice-select").removeClass("open").find(".option") }), e(document).on("click.nice_select", ".nice-select .option:not(.disabled)", function (t) { var s = e(this), n = s.closest(".nice-select"); n.find(".selected").removeClass("selected"), s.addClass("selected"); var i = s.data("display") || s.text(); n.find(".current").text(i), n.prev("select").val(s.data("value")).trigger("change") }), e(document).on("keydown.nice_select", ".nice-select", function (t) { var s = e(this), n = e(s.find(".focus") || s.find(".list .option.selected")); if (32 == t.keyCode || 13 == t.keyCode) return s.hasClass("open") ? n.trigger("click") : s.trigger("click"), !1; if (40 == t.keyCode) { if (s.hasClass("open")) { var i = n.nextAll(".option:not(.disabled)").first(); i.length > 0 && (s.find(".focus").removeClass("focus"), i.addClass("focus")) } else s.trigger("click"); return !1 } if (38 == t.keyCode) { if (s.hasClass("open")) { var l = n.prevAll(".option:not(.disabled)").first(); l.length > 0 && (s.find(".focus").removeClass("focus"), l.addClass("focus")) } else s.trigger("click"); return !1 } if (27 == t.keyCode) s.hasClass("open") && s.trigger("click"); else if (9 == t.keyCode && s.hasClass("open")) return !1 }); var n = document.createElement("a").style; return n.cssText = "pointer-events:auto", "auto" !== n.pointerEvents && e("html").addClass("no-csspointerevents"), this } }(jQuery);

$(document).ready(function () {

    /********* On scroll heder Sticky *********/
    function initHeaderSticky() {
        if (jQuery(document).height() > jQuery(window).height()) {
            if (jQuery(this).scrollTop() > 250) {
                jQuery('.site-header').addClass("fixed");
            } else {
                jQuery('.site-header').removeClass("fixed");
            }
        }
    }

    $(document).ready(function () {
        initHeaderSticky()
    });
    $(window).on('resize scroll', function () {
        initHeaderSticky()
    });

    // /********* On scroll heder back *********/
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function () {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("header-sticky").style.transform = "translateY(0)";
        } else {
            if (jQuery(this).scrollTop() > 250) {
                document.getElementById("header-sticky").style.transform = "translateY(-100%)";
            }
        }
        prevScrollpos = currentScrollPos;
    }

    /******  Nice Select  ******/
    $('.custom-select').niceSelect();

    /******  menu hover  ******/
    $(".menu-lnk.has-item").hover(function () {
        $(this).toggleClass("menu_active");
        $(this).find(".menu-dropdown").toggleClass("open_menu");
        $("body").toggleClass("no_scroll");
    });

    /********* Mobile Menu ********/
    $('.mobile-menu-button').on('click', function (e) {
        e.preventDefault();
        setTimeout(function () {
            $('body').addClass('no_scroll active_menu');
            $(".mobile-menu-wrapper").addClass("active_menu");
            $('.overlay').addClass('active');
        }, 50);
    });
    $('body').on('click', '.overlay, .menu-close-icon .close-menu', function (e) {
        e.preventDefault();
        $('body').removeClass('no_scroll active_menu');
        $(".mobile-menu-wrapper").removeClass("active_menu");
        $('.overlay').removeClass('active');
    });

    /*********  Multi-level accordion nav  ********/
    $('.acnav-label').click(function () {
        var label = $(this);
        var parent = label.parent('.has-children');
        var list = label.siblings('.acnav-list');
        if (parent.hasClass('is_open')) {
            list.slideUp('fast');
            parent.removeClass('is_open');
        }
        else {
            list.slideDown('fast');
            parent.addClass('is_open');
        }
    });
    /******* header responsive add language and currency js ********/
    function responsiveMenu() {
        if (jQuery(window).width() < 992) {
            if (!$('.mobile-lag').length > 0) {
                const newDiv = document.createElement('div');
                newDiv.className = 'mobile-lag flex align-center';
                $(newDiv).insertAfter('.menu-close-icon');
                $('.languages').prependTo('.mobile-lag');
            } else {
                return false;
            }
        }
        else {
            $('.header-style-one .languages').prependTo('.header-style-one .menu-item-right');
            $('.mobile-lag').remove();
        }
    }
    jQuery(document).ready(function () {
        responsiveMenu();
    });
    jQuery(window).resize(function () {
        responsiveMenu();
    });

    var headerClass = $('body').addClass('header-style-one');

    /*********  Header Search Popup  ********/
    $(".search-header a").click(function () {
        $(".search-popup").addClass("active");
        $("body").addClass("no_scroll");
        $('.overlay').addClass('active');
        $('body').addClass('search-overlay');
    });
    $(".close-search, .overlay").click(function () {
        $(".search-popup").removeClass("active");
        $("body").removeClass("no_scroll"); +
            $('.overlay').removeClass('active');
        $('body').removeClass('search-overlay');
    });

    /** footer acnav **/
    $(".footer-acnav").on("click", function () {
        if ($(window).width() < 768) {
            if ($(this).hasClass("is_open")) {
                $(this).removeClass("is_open");
                $(this).siblings(".footer-acnav-list").slideUp(200);
            } else {
                $(".footer-acnav").removeClass("is_open");
                $(this).addClass("is_open");
                $(".footer-acnav-list").slideUp(200);
                $(this).siblings(".footer-acnav-list").slideDown(200);
            }
        }
    });

    /****  TAB Js ****/
    $("ul.tabs li").click(function () {
        var $this = $(this);
        var $theTab = $(this).attr("data-tab");
        if ($this.hasClass("active")) {
        } else {
            $this
                .closest(".tabs-wrapper")
                .find("ul.tabs li, .tabs-container .tab-content")
                .removeClass("active");
            $(
                '.tabs-container .tab-content[id="' +
                $theTab +
                '"], ul.tabs li[data-tab="' +
                $theTab +
                "]"
            ).addClass("active");
        }
        $(this).addClass("active");
    });

    /********* qty spinner ********/
    var quantity = 0;
    $('.quantity-increment').click(function () {
        ;
        var t = $(this).siblings('.quantity');
        var quantity = parseInt($(t).val());
        $(t).val(quantity + 1);
    });
    $('.quantity-decrement').click(function () {
        var t = $(this).siblings('.quantity');
        var quantity = parseInt($(t).val());
        if (quantity > 1) {
            $(t).val(quantity - 1);
        }
    });

    /*********  profile Popup  ********/
    $(".profile-popup-btn").click(function () {
        $(".profile-popup").addClass("active");
        $("body").addClass("no_scroll");
        $('.overlay').addClass('active');
        $('body').addClass('profile-overlay');
    });
    $(".close-profile, .overlay").click(function () {
        $(".profile-popup").removeClass("active");
        $("body").removeClass("no_scroll"); +
            $('.overlay').removeClass('active');
        $('body').removeClass('profile-overlay');
    });

    /*********  Review Popup  ********/
    $(".add-review-btn").click(function () {
        $(".profile-popup").addClass("active");
        $("body").addClass("no_scroll");
        $('.overlay').addClass('active');
        $('body').addClass('profile-overlay');
    });
    $(".close-profile, .overlay").click(function () {
        $(".profile-popup").removeClass("active");
        $("body").removeClass("no_scroll"); +
            $('.overlay').removeClass('active');
        $('body').removeClass('profile-overlay');
    });

    /*** about-info-slider js ***/
    $(".about-info-slider").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="slide-arrow slick-prev"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.424091 4.51519C0.189777 4.7495 0.189777 5.1294 0.424091 5.36372L4.24247 9.18209C4.47678 9.41641 4.85668 9.41641 5.091 9.18209C5.32531 8.94778 5.32531 8.56788 5.091 8.33357L1.69688 4.93945L5.091 1.54534C5.32531 1.31103 5.32531 0.931127 5.091 0.696812C4.85668 0.462498 4.47678 0.462498 4.24247 0.696812L0.424091 4.51519ZM22.1514 4.33945L0.848356 4.33945V5.53945L22.1514 5.53945V4.33945Z" fill="white"/></svg></button>',
        nextArrow: '<button class="slide-arrow slick-next"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5759 5.48481C22.8102 5.25049 22.8102 4.8706 22.5759 4.63628L18.7575 0.817904C18.5232 0.58359 18.1433 0.58359 17.909 0.817904C17.6747 1.05222 17.6747 1.43212 17.909 1.66643L21.3031 5.06055L17.909 8.45466C17.6747 8.68897 17.6747 9.06887 17.909 9.30319C18.1433 9.5375 18.5232 9.5375 18.7575 9.30319L22.5759 5.48481ZM0.848633 5.66055L22.1516 5.66055L22.1516 4.46054L0.848633 4.46055L0.848633 5.66055Z" fill="white"/></svg></button>',
        focusOnSelect: true,
        infinite: false,
        rtl:true,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ],

    });


        /*** partner-logo-slider js ***/
        $(".partner-logo-slider").slick({
            infinite: true,    
            slidesToShow: 6,       
            slidesToScroll: 1,
            autoplay: true,         
            autoplaySpeed: 2000,    
            arrows: false,
            focusOnSelect: true,  
            rtl:true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4, 
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3, 
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2, 
                    }
                },
            ],
        
        });


            /*** category-slider js ***/
    $(".category-slider").slick({
        infinite: true,         
        autoplaySpeed: 3000,  
        arrows: true,
        prevArrow: '<button class="slide-arrow slick-prev"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.424091 4.51519C0.189777 4.7495 0.189777 5.1294 0.424091 5.36372L4.24247 9.18209C4.47678 9.41641 4.85668 9.41641 5.091 9.18209C5.32531 8.94778 5.32531 8.56788 5.091 8.33357L1.69688 4.93945L5.091 1.54534C5.32531 1.31103 5.32531 0.931127 5.091 0.696812C4.85668 0.462498 4.47678 0.462498 4.24247 0.696812L0.424091 4.51519ZM22.1514 4.33945L0.848356 4.33945V5.53945L22.1514 5.53945V4.33945Z" fill="white"/></svg></button>',
        nextArrow: '<button class="slide-arrow slick-next"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5759 5.48481C22.8102 5.25049 22.8102 4.8706 22.5759 4.63628L18.7575 0.817904C18.5232 0.58359 18.1433 0.58359 17.909 0.817904C17.6747 1.05222 17.6747 1.43212 17.909 1.66643L21.3031 5.06055L17.909 8.45466C17.6747 8.68897 17.6747 9.06887 17.909 9.30319C18.1433 9.5375 18.5232 9.5375 18.7575 9.30319L22.5759 5.48481ZM0.848633 5.66055L22.1516 5.66055L22.1516 4.46054L0.848633 4.46055L0.848633 5.66055Z" fill="white"/></svg></button>',    
        slidesToShow: 2,       
        slidesToScroll: 1,
        focusOnSelect: true, 
        rtl:true, 
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ],
       
    });

                /*** category-list-slider js ***/
                $(".category-list-slider").slick({
                    infinite: true,         
                    autoplaySpeed: 3000,  
                    arrows: false,
                    slidesToShow: 4,       
                    slidesToScroll: 1,
                    rtl:true,
                    focusOnSelect: true,  
                    responsive: [
                        {
                            breakpoint: 1400,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                            }
                        },
                        {
                            breakpoint: 475,
                            settings: {
                                slidesToShow: 1,
                            }
                        },
                    ],
                   
                });

    // Reinitialize the main slider
    $('.pro-main-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        prevArrow: '<button class="slide-arrow slick-prev"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.424091 4.51519C0.189777 4.7495 0.189777 5.1294 0.424091 5.36372L4.24247 9.18209C4.47678 9.41641 4.85668 9.41641 5.091 9.18209C5.32531 8.94778 5.32531 8.56788 5.091 8.33357L1.69688 4.93945L5.091 1.54534C5.32531 1.31103 5.32531 0.931127 5.091 0.696812C4.85668 0.462498 4.47678 0.462498 4.24247 0.696812L0.424091 4.51519ZM22.1514 4.33945L0.848356 4.33945V5.53945L22.1514 5.53945V4.33945Z" fill="white"/></svg></button>',
        nextArrow: '<button class="slide-arrow slick-next"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5759 5.48481C22.8102 5.25049 22.8102 4.8706 22.5759 4.63628L18.7575 0.817904C18.5232 0.58359 18.1433 0.58359 17.909 0.817904C17.6747 1.05222 17.6747 1.43212 17.909 1.66643L21.3031 5.06055L17.909 8.45466C17.6747 8.68897 17.6747 9.06887 17.909 9.30319C18.1433 9.5375 18.5232 9.5375 18.7575 9.30319L22.5759 5.48481ZM0.848633 5.66055L22.1516 5.66055L22.1516 4.46054L0.848633 4.46055L0.848633 5.66055Z" fill="white"/></svg></button>',
        infinite: true,
        speed: 1000,
        autoplay: false,
        rtl:true,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    /** pdp acnav **/
    $(".pdp-acnav-label").on("click", function () {
        if ($(this).hasClass("is_open")) {
            $(this).removeClass("is_open");
            $(this).siblings(".pdp-acnav-list").slideUp(200);
        } else {
            $(".pdp-acnav-label").removeClass("is_open");
            $(this).addClass("is_open");
            $(".pdp-acnav-list").slideUp(200);
            $(this).siblings(".pdp-acnav-list").slideDown(200);
        }
    });

    /*** product-slider js ***/
    $(".product-slider").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="slide-arrow slick-prev"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.424091 4.51519C0.189777 4.7495 0.189777 5.1294 0.424091 5.36372L4.24247 9.18209C4.47678 9.41641 4.85668 9.41641 5.091 9.18209C5.32531 8.94778 5.32531 8.56788 5.091 8.33357L1.69688 4.93945L5.091 1.54534C5.32531 1.31103 5.32531 0.931127 5.091 0.696812C4.85668 0.462498 4.47678 0.462498 4.24247 0.696812L0.424091 4.51519ZM22.1514 4.33945L0.848356 4.33945V5.53945L22.1514 5.53945V4.33945Z" fill="white"/></svg></button>',
        nextArrow: '<button class="slide-arrow slick-next"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5759 5.48481C22.8102 5.25049 22.8102 4.8706 22.5759 4.63628L18.7575 0.817904C18.5232 0.58359 18.1433 0.58359 17.909 0.817904C17.6747 1.05222 17.6747 1.43212 17.909 1.66643L21.3031 5.06055L17.909 8.45466C17.6747 8.68897 17.6747 9.06887 17.909 9.30319C18.1433 9.5375 18.5232 9.5375 18.7575 9.30319L22.5759 5.48481ZM0.848633 5.66055L22.1516 5.66055L22.1516 4.46054L0.848633 4.46055L0.848633 5.66055Z" fill="white"/></svg></button>',
        focusOnSelect: true,
        infinite: false,
        rtl:true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ],
    });
    /*** related-product-slider js ***/
    $(".related-product-slider").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        rtl:true,
        prevArrow: '<button class="slide-arrow slick-prev"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.424091 4.51519C0.189777 4.7495 0.189777 5.1294 0.424091 5.36372L4.24247 9.18209C4.47678 9.41641 4.85668 9.41641 5.091 9.18209C5.32531 8.94778 5.32531 8.56788 5.091 8.33357L1.69688 4.93945L5.091 1.54534C5.32531 1.31103 5.32531 0.931127 5.091 0.696812C4.85668 0.462498 4.47678 0.462498 4.24247 0.696812L0.424091 4.51519ZM22.1514 4.33945L0.848356 4.33945V5.53945L22.1514 5.53945V4.33945Z" fill="white"/></svg></button>',
        nextArrow: '<button class="slide-arrow slick-next"><svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5759 5.48481C22.8102 5.25049 22.8102 4.8706 22.5759 4.63628L18.7575 0.817904C18.5232 0.58359 18.1433 0.58359 17.909 0.817904C17.6747 1.05222 17.6747 1.43212 17.909 1.66643L21.3031 5.06055L17.909 8.45466C17.6747 8.68897 17.6747 9.06887 17.909 9.30319C18.1433 9.5375 18.5232 9.5375 18.7575 9.30319L22.5759 5.48481ZM0.848633 5.66055L22.1516 5.66055L22.1516 4.46054L0.848633 4.46055L0.848633 5.66055Z" fill="white"/></svg></button>',
        focusOnSelect: true,
        infinite: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ],
    });

    // testimonial slider 
    $(".testimonial-slider").slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplaySpeed: 2000,
        arrows: true,
        rtl:true,
        dots: false,
        focusOnSelect: true,
        nextArrow: $('.testimonial-right'),
        prevArrow: $('.testimonial-left'),
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ],
    });
    /******** progress-wrap ************/
    "use strict";
    var progressPath = document.querySelector('.progress-wrap path');
    var pathLength = progressPath.getTotalLength();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
    progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
    var updateProgress = function () {
        var scroll = $(window).scrollTop();
        var height = $(document).height() - $(window).height();
        var progress = pathLength - (scroll * pathLength / height);
        progressPath.style.strokeDashoffset = progress;
    }
    updateProgress();
    $(window).scroll(updateProgress);
    var offset = 50;
    var duration = 550;
    jQuery(window).on('scroll', function () {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.progress-wrap').addClass('active-progress');
        } else {
            jQuery('.progress-wrap').removeClass('active-progress');
        }
    });
    jQuery('.progress-wrap').on('click', function (event) {
        event.preventDefault();
        jQuery('html, body').animate({ scrollTop: 0 }, duration);
        return false;
    });
});

// Modal Window
(() => {
    const modalBtns = Array.from(document.querySelectorAll(".modal-target"));
    modalBtns.forEach(btn => {
      btn.onclick = function() {
        const modal = btn.getAttribute('data-modal');
        document.getElementById(modal).classList.toggle("active");
        document.querySelector("body").classList.toggle("no-scroll");
      }
    });
    const closeBtns = Array.from(document.querySelectorAll(".close-button"));
    closeBtns.forEach(btn => {
      btn.onclick = function() {
        let modal = btn.closest('.modal');
        btn.closest('.modal-popup').classList.toggle("active");
        document.querySelector("body").classList.toggle("no-scroll");
      }
    });
    window.onclick = function(event) {
      if (event.target.className === "modal") {
        event.target.style.display = "none";
      }
    }
})();