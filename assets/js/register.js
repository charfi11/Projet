import "../css/register.css";

var $ = require('jquery');

$("#registration_form_username").focusin(function() {
    $(".fa-user").show('fast');
}).focusout(function () {
    $(".fa-user").hide();
});

$("#registration_form_email").focusin(function() {
    $(".fa-envelope").show('fast');
}).focusout(function () {
    $(".fa-envelope").hide();
});

$("#registration_form_password").focusin(function() {
    $(".fa-lock").show('fast');
}).focusout(function () {
    $(".fa-lock").hide();
});