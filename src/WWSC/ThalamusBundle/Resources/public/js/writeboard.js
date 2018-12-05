/* show actions-panel */
$("body").delegate(".writeboards-list .writeboard .show-writeboard", 'mouseenter mouseleave', function (event) {
    if (event.type === 'mouseenter') {
        $(this).find('.actions-panel, .icon-comment-hidden').show();
    } else {
        if(!$(this).find('.actions-panel .ajaxLoading').length){
            $(this).find('.actions-panel, .icon-comment-hidden').hide();
        }
    }
});

/*delete task */
$("body").delegate(".btn-delete-writeboard", "click", function (event) {
    event.preventDefault();
    var writeboard = $(this).parents('.writeboard');
    if (!confirm("Are you sure you want to delete this writeboard?")) {
        return false;
    };
    ajaxSpinnerShow($(this).parent());
    var url = $(this).attr('href');
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                writeboard.remove();
            }
        }
    });
});

/*delete task */
$("body").delegate(".writeboard-description .btn-edit a", "click", function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parents('.writeboard-description'));
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if(data.html){
                $('.writeboard-description').html(data.html);
                $('.writeboard-description textarea').markdown({autofocus:true, savable:false, height:'inherit'})
                $('.writeboard-description textarea').css({overflow:'hidden'});
                $('.writeboard-description textarea').autogrow();
            }
        }
    });
});


$("body").delegate(".form-add-writeboard", "submit", function (event) {
    event.preventDefault();
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    if($(this).find('.attachment-preview .preview-upload').length > 0){
        attachmentFiles(this, 'writeboard', false, true);
    }else{
        this.submit();
    }
});

$("body").delegate(".form-edit-writeboard", "submit", function (event) {
    event.preventDefault();
    var form = $(this);
    ajaxSpinnerShow(form.find('.btn-save').parent());
    if($(this).find('.attachment-preview .preview-upload').length > 0){
        attachmentFiles(this, 'writeboard')
    }else{
        saveWriteboard(form);
    }
});


function saveWriteboard(form){
    var values = {};
    $.each(form.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: values,
        success: function (data) {
            if (data.error) {
                $('.writeboard-description form').find('.error').text(data.error);
                return false;
            }else{
                form.remove();
                $('.writeboard-description').html(data.html);
                $("a.fancy").fancyZoom();
                $('.markdown textarea').autogrow();
            }
        }
    });
};

$('body').delegate(".writeboard-status-user .subscribe-to-email input", "change", function (event) {
    event.preventDefault();
    ajaxSpinnerShow($(this).parent());
    var url = $('.writeboard-status-user').attr('data-url')
    if($(this).prop('checked')){
	  var url = $('.writeboard-status-user').attr('data-url')+'?action=add';
    }else{
	  var url = $('.writeboard-status-user').attr('data-url')+'?action=remove';
    }
    var aUsers = [];
    if($(this).hasClass('input-subscribed-company')){
        $.each($('.writeboard-status-user').find('.input-people-subscribed[data-company-id='+$(this).attr("data-id")+']'), function (i, field) {
            aUsers.push($(field).val());
        });
    }else{
        aUsers.push($(this).val());
    }
    $.ajax({
         type: 'POST',
         url: url,
         data: { aUsers: aUsers}
     });
});   
$('body').delegate(".show-form-etit-name, .hide-form-etit-name", "click", function (event) {
    event.preventDefault();
    if($(this).hasClass('show-form-etit-name')){
        $('.title-writeboard').hide();
        $('.edit-name-writeboard').show();
    }else{
        $('.title-writeboard').show();
        $('.edit-name-writeboard').hide();
    }
});

$('body').delegate(".edit-name-writeboard", "submit", function (event) {
        event.preventDefault();
        var form = $(this);
        ajaxSpinnerShow(form.find('.btn-update').parent());
        var values = {};
        $.each(form.serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: values,
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                }else{
                    form.hide();
                    $('.title-writeboard .name').text(data.name);
                    $('.title-writeboard').show();
                }
            }
        });
        
});

$('body').delegate(".id-version-writeboard", "click", function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    var dateVersion = $(this).text();
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if(data.html){
                $('.writeboard-description').html(data.html);
                $('.selectbox-version .label-active').text(dateVersion);
            }
        }
    });
});
