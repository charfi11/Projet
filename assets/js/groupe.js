import '../css/groupe.css';

var $ = require('jquery');

$(document).on('submit', '.formev', function(event) {
    event.preventDefault();
    const url = window.location.href;
    let data = {};
    $(this).serializeArray().forEach((object)=>{
       data[object.name] = object.value;
    });
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success:function(res){
            $('.eventform').hide();
            $(".formev :input").each(function(){
                var s = $(this).not('select');
                var v = "";
                $(s).val(v);  
                });
            // $('.event').append('<p></p>');
        }
      });
});

$(document).on('click', '.deleteingrp', function(event){
    event.preventDefault();
    const url = this.href;
    const id = this.id;
    const data = {'id' : id};

    $.ajax({
    url: url,
    dataType: 'json',
    data: data,
    success:function(){
        data;
    }
    });
});

$('.accesscrud').click(function(){
    $('.eventform').hide('slow');
    $('.crud').show('slow');
    $('.back').show('slow');
});

$('.background').click(function(){
    $('.eventform').hide('slow');
    $('.crud').hide('slow');
    $('.back').hide('slow');
});

$('.accessevent').click(function(){
    $('.eventform').toggle();
    $('.back').show('slow');
    $('.crud').hide('slow');
});

$('.closes').click(function(){
    $('.back').hide('slow');
    $('.eventform').hide('slow');
    $('.crud').hide('slow');
});

$('.ajoutfriend').click(function(){
    $('.formuser').toggle();
});

$('.coggrp').click(function(){
    $('.managegrp').toggle('slow');
});
