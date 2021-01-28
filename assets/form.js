var $ = require('jquery');

$(function() {
    if( typeof fields !== 'undefined'){
        setFields();
        $(inputField).on('change', function(){
            setFields();
        });
    }
    
    $('ul.subform').each(function(){
        $(this).data('index', $(this).find('input').length);
        $(this).find('li').each(function() {
            addDelete($(this));
        });
    });
    $('.add_item_link').on('click', function(e){
        t = $(e.currentTarget).data('collectionHolderClass');
        addRow(t);
    });
});

function setFields(){
    $('.togglefield').show();
    $('.togglefield label').removeClass('required');
    $('.togglefield select, .togglefield input').removeAttr('required');
    
    if (inputType == 'radio'){
        var curFields = fields[$(inputField+":checked").val()];
    } else {
        var curFields = fields[$(inputField).val()];
    }
    if (typeof curFields != 'undefined') {
        for (i = 0; i < curFields.required.length; i++) {
            var field = $('.field_' + curFields.required[i]);
            field.find('label').addClass('required');
            field.find('select,input').attr('required', 'required');
        }
        for(i = 0; i < curFields.not_allowed.length; i++){
            $('.field_' + curFields.not_allowed[i]).hide();
        }
        if (typeof curFields.set_value == 'object') {
            for (field in curFields.set_value){
                if (curFields.set_value[field] == 'checked'){
                    $(field).prop('checked', true);
                } else {
                    $(field).val(curFields.set_value[field]);
                }
            }
        }
    }
}

function addRow(target) {
    var subform = $('.' + target);
    var prototype = subform.data('prototype');
    var index = subform.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    subform.data('index', index + 1);
    var em = $('<li></li>').append(newForm);
    subform.append(em)
    addDelete(em);
}

function addDelete(em) {
    var btn = $('<button type="button"><span class="icon-bin"></span> Remove</button>');
    em.append(btn);
    btn.on('click', function(e) {
        em.remove();
    });
}