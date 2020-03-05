/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
var $ = require('jquery');

$(window).scroll(function() {
    if ($(document).scrollTop() > 10) {
        $('.navbar-brand').css({'font-size': '1.5em', "transition": "300ms", "padding-right": "0", "border-right": "solid 2px #d9534f"});
        $('main').css('padding-top', '100px');
        $('.vl').css({'display': 'none', "transition": "300ms"});
    }
    else {
        $('.navbar-brand').css({'font-size': '2.5em', "transition": "300ms", "padding-right": "1%", "border-right": "none"});
        $('main').css('padding-top', '85px');
        $('.vl').css({'display': 'block', "transition": "300ms"});
    }
});

$('.navuser').click(function(){
    $('#navModalNone').toggle();
})

$('.containCam').mouseover(function(){
    $('.camera').show('fast');
});

$('.containCam').mouseleave(function(){
    $('.camera').hide('fast');
})