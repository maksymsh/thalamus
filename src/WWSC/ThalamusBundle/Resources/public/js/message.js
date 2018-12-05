/* message*/
$("body").delegate(".form-add-message", "submit", function (event) {
    event.preventDefault();
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    if($(this).find('.attachment-preview .preview-upload').length > 0){
        attachmentFiles(this, 'message')
    }else{
        this.submit();
    }
});