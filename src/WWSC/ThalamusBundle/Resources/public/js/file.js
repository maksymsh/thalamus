/* file */
$("body").delegate(".list-files .file-item .show-file", 'mouseenter mouseleave', function (event) {
    if (event.type === 'mouseenter') {
        $(this).find('.actions-panel').show();
    } else {
        if(!$(this).find('.actions-panel .ajaxLoading').length){
            $(this).find('.actions-panel').hide();
        }
    }
});

/* delete file item */
$("body").delegate(".btn-delete-file", "click", function (event) {
    event.preventDefault();
    var fileItem = $(this).parents('.file-item');
    if (!confirm("Are you sure you want to delete this file?")) {
        return false;
    };
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                fileItem.remove();
            }
        }
    });
});

/* show form edit file*/
$("body").delegate(".btn-edit-file", "click", function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    var fileItem =$(this).parents('.file-item');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            console.log(data);
            fileItem.append(data.htmlFormFile);
            fileItem.find('.show-file').hide();
        }
    });
});

/* hide form edit file*/
$("body").delegate(".edit-info-file .btn-cancel", "click", function (event) {
    event.preventDefault();
    var fileItem =$(this).parents('.file-item');
    fileItem.find('.edit-info-file').remove();
    fileItem.find('.show-file').show();
});

/* update file*/
$("body").delegate(".edit-info-file", "submit", function (event) {
    event.preventDefault();
    var fileItem =$(this).parents('.file-item');
    var formFile = $(this);
    var values = {};
    $.each(formFile.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    $.ajax({
        type: formFile.attr('method'),
        url: formFile.attr('action'),
        data: values,
        success: function (data) {
            if (data.error) {
                formFile.find('.alert-error').text(data.error);
                return false;
            }
            formFile.remove();
            fileItem.find('.show-file').html(data.htmlFile).show();
        }
    });
});

$("body").delegate("#create-archive-files", "click", function (event) {
    event.preventDefault();
    var url =$(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        url: url,
        success: function (data) {
            if (data.error) {
                alert('The file cannot be downloaded through errors')
                return false;
            }
             if (data.urlDownloadZip) {
                location.href = data.urlDownloadZip;
                return false;
            }
        }
    });
});