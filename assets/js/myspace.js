import '../css/myspace.css';

var $ = require('jquery');

$(document).on('submit', '.follow', function(event) {
    event.preventDefault();
    const url = window.location.href;

    $.ajax({
        type: "POST",
        url: url,
        success:function(res){
          $('.follow').replaceWith('<a href="/myspace/21/unfollow" class="btn btn-success d-flex mt-1" id="unfollow"><strong>Suivi</strong><i class="fas fa-check ml-2 mt-1"></i></a>');
        }
      });
});

$(document).on('click', '#unfollow', function(event) {
    event.preventDefault();
    const url = this.href;
    var form = '<form name="follow" method="post" class="follow">'+
    '<input type="hidden" id="follow_friends" name="follow[friends]" value="21">'+
    '<input type="hidden" id="follow_users" name="follow[users]" value="20">'+
    '<button class="btn btn-info d-flex followBtn"><i class="fas fa-plus mt-1 mr-2 text-white" aria-hidden="true"></i><strong class="text-white">Suivre</strong></button>'+
    '<input type="hidden" id="follow__token" name="follow[_token]" value="_6WEUQS2KxTbZ3I3hcDyCBNt2bIHGgCbuY9VPgAIq0k"></form>'
    $.ajax({
        url: url,
        success:function(res){
            $('#unfollow').replaceWith(form);
        }
      });
});

$(document).ready(function(){
    var form = document.getElementsByClassName('inviteform'); 
    var arr = Array.from(form);
    arr.forEach(element => 
    {var a = element
$(a).on('submit', this, function(event){
    event.preventDefault();
    const url = window.location.href;
    const valgrp = event.target.children[2].value;
    const valuser = event.target.children[1].value;
    const data = {'idg' : valgrp, 'idu' : valuser};
    const urlDel = 'http://127.0.0.1:8000/myspace/'+this.name+'/deleteins';

    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success:function(res){
            data;
            var card = '<div class="grpSpace col-md-3"><a href="http://127.0.0.1:8000/groupe/'+res.id+'"><img class="imgGrp" src="../img/'+res.img+'" alt="grpimg" style="width: 100%;"><p class="grpName">'+res.name+'</p></a></div>';
            $('.blockgrpinvite').append(card);
            $('.grpinvite').remove();
            $(event.target).hide();
        }
      });
      $.ajax({
        url: urlDel,
        success:function(){
        }
    });
    });
});
});

$(document).on('click', '.deletein', function(event){
    event.preventDefault();
    const url = this.href;
    const form = event.target.parentElement.parentElement;
    $.ajax({
    url: url,
    success:function(){
        $(form).hide();
    }
    });
});

$('.avatarCamera').click(function(){
    $('.formimgupdate').toggle();
});

$('.editGrpBlock').click(function(){
    $('.editFormGrp').toggle('fast');
    $('.back1').toggle();
    $('.back2').hide();
    $('.back3').hide();
    $('.back4').hide();
    $('.back5').hide();
    $('.editFormUser').hide();
    $('.modalPlus').hide();
    $('.eventFormUser').hide(); 
    $('.editBoard').hide();
});

 $('.editUserBlock').click(function(){
    $('.editFormUser').toggle('fast');
    $('.back2').toggle();
    $('.back1').hide();
    $('.back3').hide();
    $('.back4').hide();
    $('.back5').hide();
    $('.editFormGrp').hide();
    $('.modalPlus').hide();
    $('.eventFormUser').hide();
    $('.editBoard').hide(); 
});

$('.spaceFormevent').click(function(){
    $('.eventFormUser').toggle('fast');
    $('.back3').toggle();
    $('.back1').hide();
    $('.back2').hide();
    $('.back4').hide();
    $('.back5').hide();
    $('.editFormUser').hide();
    $('.editFormGrp').hide();
    $('.modalPlus').hide(); 
    $('.editBoard').hide();
});

$('.boardgrp').click(function(){
    $('.editBoard').toggle('fast');
    $('.back5').toggle();
    $('.back1').hide();
    $('.back2').hide();
    $('.back3').hide();
    $('.back4').hide();
    $('.eventFormUser').hide();
    $('.editFormUser').hide();
    $('.editFormGrp').hide();
    $('.modalPlus').hide(); 
});

$('.spacePlus').click(function(){
    $('.modalPlus').toggle('fast');
    $('.back1').hide();
    $('.back2').hide();
    $('.back3').hide();
    $('.back4').hide();
    $('.back5').hide();
    $('.eventFormUser').hide();
    $('.editBoard').hide();
    $('.editFormGrp').hide();
});

$('.modifUserform').click(function(){
    $('.editFormUser').toggle('fast');
    $('.back4').toggle();
    $('.back1').hide();
    $('.back2').hide();
    $('.back3').hide();
    $('.back5').hide();
    $('.eventFormUser').hide();
    $('.editBoard').hide(); 
});

$('.inviteselect').click(function(){
    $('.inviteblock').toggle();
});
