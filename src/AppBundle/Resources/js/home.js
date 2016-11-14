$(document).ready(function(){
    //Chamada Slider
    $('.slider').slider();

    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();

    // Chamada select destinos
    $('select').material_select();

    var swiper = new Swiper('.swiper-container', { // HTML element selector
        slidesPerView: "auto",
        pagination: '.swiper-pagination',
        spaceBetween: 11, // Space between the slides,
        autoplay: 4500,
        autoplayDisableOnInteraction: false
    });
});