/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import './styles/app.css';
import './styles/style.scss';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
$(function() {
    $('a[href^="https://"]').attr('target','_blank');
    $('.worldMap').on('click', function(){
        $(this).parents('.sticky').toggleClass('fullMap');
    });
    $('.worldMap').on('mousemove', function(e){
        $('#toolTip').css('top', e.pageY).css('left', e.pageX + 20)
    })
    $('.worldMap path').on('mouseover', function(){
        var str = $(this).attr('title');
        if(typeof registrations != 'undefined' && typeof registrations[$(this).attr('id')] != 'undefined'){
            str = str + ' - ' + registrations[$(this).attr('id')];
        }
        $('#toolTip').text(str).show();
    });
    $('.worldMap path').on('mouseout', function(){
        $('#toolTip').text('').hide();
    });
});