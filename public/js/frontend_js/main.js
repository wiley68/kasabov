
/*
Theme Name:       Classix - Classified Ads and Listing Template
Author:           UIdeck
Author URI:       http://uideck.com
Text Domain:      UIdeck
Domain Path:      /languages/

JS INDEX
================================================
1. preloader js
2. scroll to top js
3. slick menu js
4. sticky menu js
6. counter js
9. wow js
7. Testimonial owl carousel
8. New Products owl carouse
9. Categories Iocn owl Carousel
================================================*/

(function ($) {

    var $main_window = $(window);

    /*====================================
    preloader js
    ======================================*/
    $main_window.on("load", function () {
        $("#preloader").fadeOut("slow");
    });

    /*====================================
    scroll to top js
    ======================================*/
    $main_window.on("scroll", function () {
        if ($(this).scrollTop() > 250) {
            $(".back-to-top").fadeIn(200);
        } else {
            $(".back-to-top").fadeOut(200);
        }
    });
    $(".back-to-top").on("click", function () {
        $("html, body").animate(
            {
                scrollTop: 0
            },
            "slow"
        );
        return false;
    });

    /*====================================
    slick menu js
    ======================================*/
    var logo_path = $('.mobile-menu').data('logo');
    $('#main-navbar').slicknav({
        appendTo: '.mobile-menu',
        removeClasses: false,
        label: '',
        closedSymbol: '<i class="lni-chevron-right"><i/>',
        openedSymbol: '<i class="lni-chevron-right"><i/>',
        brand: '<a href="index.html"><img src="' + logo_path + '" class="img-responsive" alt="logo"></a>'
    });

    /*====================================
    sticky menu js
    ======================================*/
    $main_window.on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 10) {
            $(".scrolling-navbar").addClass("top-nav-collapse");
        } else {
            $(".scrolling-navbar").removeClass("top-nav-collapse");
        }
    });

    /*=======================================
    counter
    ======================================= */
    if ($(".counter").length > 0) {
        $(".counterUp").counterUp({
            delay: 10,
            time: 2000
        });
    }

    /*====================================
    wow js
    ======================================*/
    var wow = new WOW({
        //disabled for mobile
        mobile: false
    });
    wow.init();

    /*====================================
    Tooltip Toggle
    ======================================*/
    $('[data-toggle="tooltip"]').tooltip()

    /*====================================
    Testimonials Carousel
    ======================================*/
    var testiOwl = $("#testimonials");
    testiOwl.owlCarousel({
        autoplay: true,
        margin: 30,
        dots: false,
        autoplayHoverPause: true,
        nav: false,
        loop: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            991: {
                items: 2
            }
        }
    });

    /*====================================
    New Products Owl Carousel
    ======================================*/
    var newproducts = $("#new-products");
    newproducts.owlCarousel({
        autoplay: true,
        nav: true,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: false,
        margin: 30,
        loop: true,
        navText: [
            '<i class="lni-chevron-left"></i>',
            '<i class="lni-chevron-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 2,
            },
            991: {
                items: 3,
            }
        }
    });

    /*====================================
    Categories Iocn Owl Carousel
    ======================================*/
    var categoriesslider = $("#categories-icon-slider");
    categoriesslider.owlCarousel({
        autoplay: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: true,
        margin: 30,
        loop: true,
        navText: [
            '<i class="lni-chevron-left"></i>',
            '<i class="lni-chevron-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 2,
            },
            991: {
                items: 5,
            }
        }
    });

    /*====================================
    Details  Owl Carousel
    ======================================*/
    var detailsslider = $("#owl-demo");
    detailsslider.owlCarousel({
        autoplay: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: true,
        margin: 30,
        loop: true,
        navText: [
            '<i class="lni-chevron-left"></i>',
            '<i class="lni-chevron-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 1,
            },
            991: {
                items: 1,
            }
        }
    });

    // Validate register user form
    $("#register_form").validate({
        rules: {
            register_name: {
                required: true,
                minlength: 2
            },
            register_email: {
                required: true,
                email: true,
                remote: "/check-email"
            },
            register_password:{
				required: true,
				minlength: 6,
				maxlength: 20
			},
			register_password_again:{
				required: true,
				minlength: 6,
				maxlength: 20,
				equalTo: "#register_password"
			}
        },
        messages: {
            register_name: {
                required: "Моля въведете Вашите имена",
                minlength: "Минималната дължина на полето е 2 символа"
            },
            register_email: {
                required: "Моля въведете Вашия e-mail адрес",
                email: "Моля въвдете валиден e-mail адрес",
                remote: "Вече има регистриран потребител с този e-mail адрес!"
            },
            register_password: {
                required: "Моля въведете вашата парола",
                minlength: "Вашата парола трябва да бъде най-малко 6 символа",
                maxlength: "Вашата парола трябва да бъде най-много 20 символа"
            },
            register_password_again: {
                required: "Моля въведете вашата парола",
                minlength: "Вашата парола трябва да бъде най-малко 6 символа",
                maxlength: "Вашата парола трябва да бъде най-много 20 символа",
                equalTo: "Въведената от Вас парола не съответства на първата въведена"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('error');
            $(element).addClass('success');
        }
    });

    // Validate register user form
    $("#home_settings").validate({
        rules: {
            user_name: {
                required: true
            },
            user_phone: {
                required: true
            },
            user_agrrement: {
                required: true
            }
        },
        messages: {
            user_name: {
                required: "Моля въведете Вашите имена"
            },
            user_phone: {
                required: "Моля въведете Вашия телефон за връзка"
            },
            user_agrrement: {
                required: "Необходимо е да се съгласите с Общите ни условия"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('error');
            $(element).addClass('success');
        }
    });

    // Validate register order form
    $("#order_products").validate({
        rules: {
            user_email: {
                required: true,
                email: true
            }
        },
        messages: {
            user_email: {
                required: "Моля въведете Вашия email адрес",
                email: "Моля въвдете валиден e-mail адрес"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('error');
            $(element).addClass('success');
        }
    });

    // Validate register product form
    $("#home_firm_product_edit").validate({
        rules: {
            product_name: {
                required: true
            },
            product_code: {
                required: true,
                maxlength: 191,
                remote: "/admin/check-product?id=" + $('#product_id').val()
            },
            price:{
				required:true,
				number:true
			}
        },
        messages: {
            product_name: {
                required: "Моля въведете име на продукта!"
            },
            product_code: {
                required: "Моля въведете код на продукта!",
                maxlength: "Максималната дължина на полето е 191 символа",
                remote: "Вече има регистриран друг продукт с този код! Не можете да го използвате отново!"
            },
            price: {
                required: "Моля въведете цена на продукта!",
                number: "Можете да въвеждате само числа!"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('error');
            $(element).addClass('success');
        }
    });

})(jQuery);
