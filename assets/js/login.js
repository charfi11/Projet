import '../css/login.css';

var $ = require('jquery');

$("#inputEmail").focusin(function() {
    $(".fa-envelope").show('fast');
}).focusout(function () {
    $(".fa-envelope").hide();
});

$("#inputPassword").focusin(function() {
    $(".fa-user-lock").show('fast');
}).focusout(function () {
    $(".fa-user-lock").hide();
});