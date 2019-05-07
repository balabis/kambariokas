var $ = require('jquery');

(function() {
    var maxAnsweredQuestion = 0;
    var carouselLength = $('.carousel-item').length - 1;

    $('.answer').click(function () {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        maxAnsweredQuestion = $('.carousel-inner > .active').index('.carousel-item')> maxAnsweredQuestion ?
            $('.carousel-inner > .active').index('.carousel-item'): maxAnsweredQuestion;

        if ($('.carousel-inner > .active').index('.carousel-item') === $('.carousel-item').length - 1) {
            $(this).siblings('[type=radio]').on('change',function(){
                $('.questionnaire-form').submit();
                $('.questionnaire-form').addClass('d-none');
            });
        } else {
            $('.carousel').carousel('next');
        }
    });

    $('.prev').click(function () {
        $('.carousel').carousel('prev');
    });

    $('.next').click(function () {
        $('.carousel').carousel('next');
    });

    $('.carousel').carousel({
        interval: false,
        wrap: false
    }).on('slide.bs.carousel', function (e) {
        if (e.to === 0) {
            $('.prev').addClass('d-none');
        }
        else if (e.to === carouselLength) {
            $('.prev').removeClass('d-none');
            $('.next').addClass('d-none');
        }
        else {
            $('.prev').removeClass('d-none');
            $('.next').removeClass('d-none');
        }

        if (e.to <= maxAnsweredQuestion) {
            $('.next').removeClass('d-none');
        }
        else {
            $('.next').addClass('d-none');
        }
    });
})();




