$(function (){
    'use strict' ;
    $('[placeholder]').focus(function(){
       $(this).attr('data-text', $(this).attr('placeholder')) ;
       $(this).attr('placeholder' , '');
    }).blur ( function(){
        $(this).attr('placeholder' , $(this).attr('data-text'));
    });


   
    // add an astrik on required field
    /*$('input').each(function(){
    if($(this).attr('required')==='required'){
        $(this).after('<span class="asterisk">*</span>')
    }
    });*/
    // confirmation message when deleting members
    $('.confirm').click(function(){
        return confirm('Do you wante to delete this ?') ;
    });
$('.live-name').keyup(function(){
    $('.live-preview .caption h3').text($(this).val()) ;
});
$('.live-desc').keyup(function(){
    $('.live-preview .caption p').text($(this).val()) ;
});
$('.live-price').keyup(function(){
    $('.live-preview .price-tag').text('$'+$(this).val()) ;
});
    
});