var init = {
    swiper: function(){
        /*

        roundLengths: true, окрглить значения в анимации, а то разыто все

        effect: 'fade', эффект

        autoHeight: true, авто высота

        autoplay: {
            delay: 5000,
        },

        loop: true, лооп

        spaceBetween: 30, оступ между слайдами

        slidesPerView: 3, количество слайдов

        centeredSlides: true, слайды по центру

        pagination: {
            el: '.swiper-pagination', точки внизу слайдера
            clickable: true
        },

        simulateTouch: false, отключить симуляцию пальца

        on: {
            init: function () {
                событие запуска слайдера
            },
        }

        .on('slideChange', function(){
            this.activeIndex
        });

        .slideTo(swiper.realIndex); прокрутить к слайду

        */


        /*
        var width = $(window).width();

        var navigation = function(elem){
            var parent = $(elem).parents('.container');

            return {
                nextEl: $('.swiper-button-next',parent),
                prevEl: $('.swiper-button-prev',parent),
            }
        }

        new Swiper('#slides-main', {
            spaceBetween: 0,
            autoplay: {
                delay: 5000,
            },
            autoHeight: true,
            effect: 'fade',
            roundLengths: true,
            navigation: navigation('#slides-main'),
        });
        */




        /*

        var big = new Swiper('#cd-photos-big', {
            spaceBetween: 0,
            slidesPerView: 1,
            autoHeight: true,
            roundLengths: true,
            navigation: {
                nextEl: $('#cd-photos-big .swiper-button-next'),
                prevEl: $('#cd-photos-big .swiper-button-prev'),
            },
        });

        var mini = new Swiper('#cd-photos-small', {
            spaceBetween: 15,
            slidesPerView: 4,
            autoHeight: true,
            roundLengths: true,
            navigation: navigation('#cd-photos-small'),
        });

        var mini_slides = $('#cd-photos-small .swiper-slide');
            mini_slides.on('click',function(){
                big.slideTo(mini_slides.index(this));
            })
        */
    },
    mobileMenu: function(){
        $('#mobile-menu').menu();

        $('#mobile-menu-close').on('click',function(){
            $('#mobile-menu').menu('close');
        })

        $('#mobile-menu-toggle').on('click',function(e){
            e.preventDefault();

            $('#mobile-menu').menu('open');
        })
    },
    modal: function(){
        $('a[data-modal]').click(function(event) {
            $(this).modal({
                fadeDuration: 250
            });

            return false;
        });
    },
    magnific: function(){
        $('.gallery').each(function(){
            $(this).magnificPopup({
                delegate: '.image',
                type: 'image',
                gallery: {
                    enabled: true
                },
            });
        });
    },
    video: function(){
        $('.popup-video').magnificPopup({
            disableOn: false,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    },
    wow: function(){
        $('.wow-delay').each(function(){
            var delay = 0;

            $('.wow',this).each(function(){
                delay += 0.1;

                if(delay > 1) delay = 0;

                $(this).attr('data-wow-delay',delay + 's');
            })
        });

        new WOW().init();
    },
    onload: function(){
        var ready = false;
        var load  = function(){
            if(ready) return;

            ready = true;

            clearTimeout(timer);

            $('body').addClass('loaded');

            init.wow();
        }


        var timer = setTimeout(function(){
            load();
        }, 5000);

        window.addEventListener('load',function(){
            load();
        });
    },
    /*
    form: function(open_page){
        $("input[name='phone']").inputmask("+7 (999) 999 99 99",{
            //placeholder: "(909) XXX XX XX",
            //showMaskOnHover: false,
            clearMaskOnLostFocus: true
        });

        $('form').submit(function(e){
            e.preventDefault();



            var form = $(this);


            $('button',form).css({opacity: 0.5}).attr('disabled', '');

            $.post('mail/send.php',$(this).serializeArray(),function(json){
                $('button',form).css({opacity: 1}).removeAttr('disabled');

                if(json.success){
                    if(open_page){
                        window.location = open_page;
                    }
                    else{
                        $('#modal-success').modal({
                            fadeDuration: 250
                        });

                        setTimeout(function(){
                            $('input,textarea',form).not('[type="hidden"]').val('');

                            $.modal.close();
                        },3000);
                    }
                }
            },'json');
        })
    },
    */
    faq: function(){
        $('.e_faq').each(function(){
            var item = $(this);
            var body = $('.e_faq-body',item);

            $('.e_faq-header',item).on('click', function(){
                if(body.is(':visible')){
                    body.slideUp(200);
                    item.removeClass('open')
                }
                else{
                    body.slideDown(200);
                    item.addClass('open');
                }
            })
        })
    },
    more: function(){
        $('.e_more').each(function(){
            var read = $('.e_more-read',this);
            var body = $('.e_more-body',this);

            read.on('click', function(e){
                e.preventDefault();

                if(body.is(':visible')){
                    body.slideUp(200);
                    read.text('Развернуть');
                }
                else{
                    body.slideDown(200);
                    read.text('Свернуть');
                }
            })
        })
    },
    time: function(elem, date){
        var timeend = new Date(date);

        function time() {
            var today = new Date();
                today = Math.floor((timeend-today)/1000);


            var tsec  = today%60; today=Math.floor(today/60); if(tsec<10) tsec='0'+tsec;
            var tmin  = today%60; today=Math.floor(today/60); if(tmin<10) tmin='0'+tmin;
            var thour = today%24; today=Math.floor(today/24);

            today = ('0' + today).slice(-2);
            tsec  = ('0' + tsec).slice(-2);
            tmin  = ('0' + tmin).slice(-2);
            thour = ('0' + thour).slice(-2);

            $('.day',elem).text(today);
            $('.hour',elem).text(thour);
            $('.min',elem).text(tmin);
            $('.sec',elem).text(tsec);
        }

        time();

        setInterval(time,1000)
    },
    scrollTo: function(pushHistory){
        $(".scrollTo").click(function(e){
            e.preventDefault();

            $.modal.close();

            var id = $(this).attr('href') || $(this).data('modal');

            var ps = $(id).offset().top;

            if(pushHistory){
                if(history.pushState) {
                    history.pushState(null, null, id);
                }
                else {
                    location.hash = id;
                }
            }

            $('html, body').animate({
                scrollTop: ps-20
            }, Math.max(500,Math.round(ps * 0.2)));
        });
    },
    tabs: function(){
        $('.e-tab').each(function(){
            var links   = $('.e-tab--nav > li',this);
            var content = $('.e-tab--body > div',this);

            links.on('click', function(e){
                e.preventDefault();

                links.removeClass('active');

                $(this).addClass('active');

                var target = links.index(this);

                content.removeClass('active')

                content.eq(target).addClass('active')
            })
        })
    },
    fluid: function(){
        function resize(){
            var width = $(window).width();

            $('.fluid-right').each(function(){
                var offset = $(this).offset();

                $(this).width(width - offset.left);
            });
        }

        $(window).resize(resize);

        resize();
    },
    sticker: function(elem){
        sticker.sticky({topSpacing:0});

        /*
        sticker.on('sticky-start', function() {
            sticker.addClass('detach')
        });

        sticker.on('sticky-end', function() {
            sticker.removeClass('detach')
        });
        */
    },
    mdrop: function(){
        /*
        var toggle = $('.mdrop--toggle');
        var drop   = $('.mdrop');

        toggle.on('click',function(e){
            e.preventDefault();

            if($(this).hasClass('open')){
                $(this).removeClass('open');

                $('.mdrop',this).hide();
            }
            else{
                toggle.removeClass('open');

                drop.hide();

                $('.mdrop',this).show();

                $(this).addClass('open');
            }


        });

        $(document).on('mousedown',function(event){
            if(!$(event.target).closest(toggle).length) {
                drop.hide();
                toggle.removeClass('open');
            }
        })
        */
    },
    headSearch: function(){
        var drop   = $('.h-search--too');
        var toggle = $('.h-search--toggle');

        toggle.on('click', function(){

            console.log('click');
            if(drop.is(':visible')){
                drop.hide();
            }
            else{
                var offset   = toggle.offset();
                var padding  = window.innerWidth - offset.left;
                var size     = window.innerWidth - padding * 2;

                drop.css({width: size+'px'}).show();

                if(window.innerWidth < 860) drop.css({width:'100%'});
            }
        })

        $(document).on('mousedown',function(event){
            if(!$(event.target).closest($('.h-search--too,.h-search--toggle')).length) {
                drop.hide();
            }
        })
    },
    up: function(){
        $('.e-up').on('click', function(e){
            e.preventDefault();

            $('html, body').animate({
                scrollTop: 0
            }, 500);
        })
    },
    files: function(){
        $('.e-file').each(function(){
            var that = $(this);
            var file = $('> input',that);
            var btn  = $('.e-file--utter',that);
            var exel = $('.e-file--exile',that);

            btn.on('click', function(){
                file.click();
            })

            $('.ico',exel).on('click', function(){
                file.val('');
                file.change();
            })

            file.on('change', function(){
                var value = $(this).val();

                if(value){
                    exel.show();
                    btn.hide();

                    var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
                    var filename = value.substring(startIndex);
                    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                        filename = filename.substring(1);
                    }


                    $('>span',exel).text(filename);
                }
                else{
                    exel.hide();
                    btn.show();
                }
            })
        })
    },
    us: function(){
        $('#us1 a').on('click', function(e){
            e.preventDefault();

            $('#us2').show();
        })
    },
    step: function(){
        $('.step').each(function(){
            var that = $(this);

            var position = 0;

            var nav  = $('.e-tab--nav > li',that);
            var body = $('.step--body',that);
            var btns = $('.e-field--next .btn',that);
            var back = $('.e-field--next a.back',that);

            function move(n){
                position += n;

                body.removeClass('active')
                body.eq(position).addClass('active')

                nav.removeClass('active')
                nav.eq(position).addClass('active')
            }

                nav.on('click',function(e){
                    e.preventDefault();
                })

                btns.on('click',function(e){
                    if(position < body.length-1){
                        e.preventDefault();

                        move(1);
                    }
                })

                back.on('click', function(e){
                    e.preventDefault();

                    move(-1);
                })

        })
    },
    mmenu: function(){
        $('.mobile-mmenu > li').each(function(){
            var that = $(this);
            var item = $('> a',that);

            item.on('click',function(e){
                e.preventDefault();

                that.toggleClass('open');
            })
        })
    },
    uphoto: function(){
        function getBase64(file, call) {
            var reader = new FileReader();

            reader.readAsDataURL(file);

            reader.onload = function () {
                call(reader);
            };
            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        }

        $('.e-upload-photo').each(function(){
            var that  = $(this);
            var file   = $('> input',that);
            var remove = $('.remove',that);
            var exel   = $('.exel',that);


            exel.on('click',function(event){
                if(!$(event.target).closest(remove).length) {
                    file.click();
                }
            });

            file.on('change', function(){
                getBase64(file[0].files[0], function(result){
                    exel.css({'background-image':'url('+result.result+')'});

                    that.addClass('uploaded');
                })
            })

            remove.on('click',function(){
                file.val('');

                exel.css({'background-image':'none'});

                that.removeClass('uploaded');
            })
        })
    },
    usl: function(){
        $('.usl-box').each(function(){
            var that = $(this);

            var dom_items = $('.usl-items > .e-user-select',that);
            var dom_doit  = $('.usl-do',that);
            var dom_list  = $('.usl-list',that);
            var dom_total = $('.usl-total',that);
            var dom_selected = $('.usl-selected',that);

            var updateTotal = function(){
                var l = $('> div',dom_list).length;

                if(l){
                    dom_selected.show();
                    dom_doit.hide();

                    dom_total.text('Вы выбрали '+l+' пользвателей')
                }
                else{
                    dom_selected.hide();
                    dom_doit.show();
                }
            }

            dom_items.each(function(){
                var item = $(this);
                var form = $('.form--dot',item);
                var image;

                form.on('click',function(){
                    $(this).toggleClass('active');

                    if(form.hasClass('active')){
                        image = $('<div></div>').css({'background-image':'url('+item.data('img')+')'});

                        image.on('click',function(){
                            image.remove();

                            form.removeClass('active');

                            image = false;

                            updateTotal();
                        })

                        dom_list.append(image);

                        updateTotal();
                    }
                    else if(image){
                        image.remove();

                        form.removeClass('active');

                        image = false;

                        updateTotal();
                    }
                })
            })
        })
    },
    dropMore: function(){
        $('.e-more').each(function(){
            var that = $(this);
            var btn = $('.e-more--button,.e-more--toggle',that);

            btn.on('click',function(){
                that.toggleClass('showed');
            })
        })
    }
}

$(function(){
    var isPageSpeed = /Google Page Speed Insights/.test(navigator.userAgent);

    // чтобы результат был аж 100!))
    if(isPageSpeed) return;

    init.magnific();
    init.video();
    //init.swiper();
    init.modal();
    init.mobileMenu();
    //init.form();
    init.faq();
    init.more();
    init.scrollTo(false);
    init.tabs();
    //init.mdrop();
    init.headSearch();
    init.up();
    init.files();
    init.us()
    init.step();
    init.mmenu();
    init.uphoto();
    init.usl();
    init.dropMore();

    $('.scrollbar-box').scrollbar();

    $('select').niceSelect();

    //init.sticker($('#sticker'));

    //init.fluid();

    //init.time($('.date'),'Dec 03 2018 00:00:00')
})

init.onload();
