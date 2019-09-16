

$(function () {
    if($(document).scrollTop() > 50){
        $('#navbarHero').addClass('scrolledNav');
        $('#navLogo1').attr('style', 'display:none');
        $('#navLogo2').attr('style', 'height:auto;width:7em;padding-bottom:5px;');
    } else {
        $('#navbarHero').removeClass('scrolledNav');
        $('#navLogo1').attr('style', 'height:auto;width:2em');
        $('#navLogo2').attr('style', 'display:none;');
    }

    $(window).scroll(function () { 
        if($(document).scrollTop() > 50){
            $('#navbarHero').addClass('scrolledNav');
            $('#navLogo1').attr('style', 'display:none');
            $('#navLogo2').attr('style', 'height:auto;width:7em;padding-bottom:5px;');
        } else {
            $('#navbarHero').removeClass('scrolledNav');
            $('#navLogo1').attr('style', 'height:auto;width:2em');
            $('#navLogo2').attr('style', 'display:none;');
        }
    });

    $('.navbar-toggler').click(function (e) { 
        e.preventDefault();
        if($('.navbar-toggler').attr('aria-expanded') == 'false'){
            $('#navbarHero').addClass('nav-bar-opened');
        }
        else {
            $('#navbarHero').removeClass('nav-bar-opened');
        }
    });
});