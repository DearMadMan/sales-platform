$(function(){
    $(".user-nav li").each(
        function(){
           $(this).css({
               'height':$(this).outerWidth()+'px',
               'line-height':$(this).outerWidth()+'px'
           });
        }
    );




    var mySwiper = new Swiper ('.swiper-container', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: '.swiper-pagination',

        // Navigation arrows
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        autoplay: 3000
        // And if we need scrollbar
       // scrollbar: '.swiper-scrollbar',
    })

});