$(function (){
    'use strict' ;
    $('[placeholder]').focus(function(){
       $(this).attr('data-text', $(this).attr('placeholder')) ;
       $(this).attr('placeholder' , '');
    }).blur ( function(){
        $(this).attr('placeholder' , $(this).attr('data-text'));
    });


    $('.toggle-info').click(function(){
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(200) ;
        if($(this).hasClass('selected')){
            $(this).html( 
                '<i class="fas fa-plus fa-lg"></i>'
            )  ;
        }else{
            $(this).html( 
                '<i class="fas fa-minus fa-lg"></i>' );
        }
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

    $('.cat h3').click(function(){
     $(this).next('.full-view').fadeToggle(200) ;
    });
     $('.ordering  span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active') ;
        if($(this).data('view') ==='classic'){
            $('.cat .full-view').fadeOut(200) ;
        }else {
            $('.cat .full-view').fadeIn(100) ;
        }
    });
});