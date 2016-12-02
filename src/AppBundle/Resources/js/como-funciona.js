$(document).ready(function(){
    //Chamada Slider
    $('.slider').slider();

    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();

    // Chamada select destinos
    $('select').material_select();

    $('#idInfo_0_detail').css({"border":"3px solid #ff4242"});
    $('#idInfo_0_detail').show();

    $('#highlight_0').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_0_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_0_detail').hide();
        }
    );

    $('#highlight_1').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_1_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_1_detail').hide();
        }
    );
    $('#highlight_2').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_2_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_2_detail').hide();
        }
    );
    $('#highlight_3').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_3_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_3_detail').hide();
        }
    );
    $('#highlight_4').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_4_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_4_detail').hide();
        }
    );

    var swiper = new Swiper('.swiper-container', { // HTML element selector
        slidesPerView: "auto", // How many slides do we want per view? You can specify a number
        spaceBetween: 11, // Space between the slides
        freeMode: false, // Free rolling slider
        loop: true, // Swiper loops your slides, and there is no ending point
        loopedSlides: 8, // Safe option which needs to be set if you use slidesPerView: 'auto'
        autoplay: 4500,
        autoplayDisableOnInteraction: false,
        pagination: '.swiper-pagination'
    });
});
