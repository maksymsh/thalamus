
$('body').delegate(".btn-add-project-company", "click", function () {
    $('.forms-company-to-project').slideDown("slow");
    $(this).hide();
});
$('body').delegate(".form-select-company-to-project .btn-cancel, .form-add-new-company-project .btn-cancel", "click", function (event) {
    event.preventDefault();
    $(this).parents('.forms-company-to-project').hide();
    $(".btn-add-project-company").show();
});  

$('body').delegate(".link-select-company", "click", function (event) {
    event.preventDefault();
    $('.form-select-company-to-project').show();
    $(".form-add-new-company-project").addClass('hide');
}); 

$('body').delegate(".link-add-new-company", "click", function (event) {
    event.preventDefault();
    $('.form-select-company-to-project').hide();
    $(".form-add-new-company-project").removeClass('hide');
}); 

$('body').delegate(".add-people-to-project .project-people", "change", function (event) {
    event.preventDefault();
    ajaxSpinnerShow($(this).parent());
	if($(this).prop('checked')){
	  var url = $(this).attr('data-href')+'?action=add';
	}else{
	  var url = $(this).attr('data-href')+'?action=remove';
	}
    $.ajax({
         type: "GET",
         url: url
     });
});   
   