$('.btn-delete-company').click(function () {
    if (!confirm("Are you sure you want to remove this company.?")) {
        return false;
    }
    ;
})
$('.btn-delete-user').click(function () {
    if (!confirm("Are you sure you want to remove this person.?")) {
        return false;
    }
    ;
})
$('.btn-delete-project').click(function () {
    if (!confirm("Are you sure you want to remove this project.?")) {
        return false;
    }
    ;
})
$('.remove_img').click(function () {
    if (!confirm("Are you sure you want to remove this image.?")) {
        return false;
    }
    ;
    $('#' + $(this).attr('data-img-id')).val('');
    $(this).parent().remove();
})

$(".finance-table-all-project tr td.price:contains('-'), .finance-table tr  td.price:contains('-')").addClass('negative');

$('#filters-task-table select, #filters-task-table input').change(function () {
    $('#filters-task-table').submit();
});

$("body").delegate(".changing-order-list-project", "change", function (event) {
    var url = $(this).val();
    $.get(url, function (data) {
        $('.list-open-project-right').html(data.dashboardMenuProject)
    });
});

/*
 $("body").delegate("#wwsc_thalamusbundle_project_responsible_company", "change", function (event) {
 var url = '/company/users/'+$(this).val();
 $.get(url, function(data){
 $('.projectleaderBox').html(data.selectUser)
 });
 });*/



$("body").delegate("#login-form-user", "submit", function (event) {
    event.preventDefault();
    var url = $(this).attr('action');
    $.ajax({
        type: $('form').attr('method'),
        url: url,
        data: $('form').serialize(),
        dataType: "json",
        success: function (data, status, object) {
            if (data.success) {
                location.href = data.urlCreateNewAccount;
            } else {
                $('.error').html(data.message);
            }
        },
        error: function (data, status, object) {
        }
    });
});

$("body").delegate(".add-user-form", "submit", function (event) {
    var url = '/company/' + $('#company_id').val() + '/user/check-user-exist';
    var status = false;
    var project = null;
    if ($('#wwsc_thalamus_user_project')) {
        project = $('#wwsc_thalamus_user_project').val();
    }
    var formData = {email: $('#wwsc_thalamusbundle_user_email').val(), firstName: $('#wwsc_thalamusbundle_user_first_name').val(), lastName: $('#wwsc_thalamusbundle_user_last_name').val(), project: project};
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        async: false,
        success: function (data) {
            status = data.status;
            if (status == false) {
                $('.panel-body .row').append(data.htmlpopup);
                $('.add-existing-user').modal('show')
                $('.add-existing-user').on('hidden.bs.modal', function () {
                    $('.add-existing-user').remove();
                })
                $('.add-existing-user .btn-cancel').on('click', function () {
                    $('.add-existing-user').remove();
                })
            }
        }
    });
    return status;
});

/* ajax spinner */
function ajaxSpinnerShow(spinnerBox, type) {
    spinnerBox.children().hide();
    if (type === undefined || type == "small") {
        spinnerBox.append('<img class="ajaxLoading" src="/bundles/wwscthalamus/images/ajax-loader.gif">');
    } else {
        spinnerBox.append('<img class="ajaxLoading" src="/bundles/wwscthalamus/images/loading-bar.gif">');
    }
}

$(document).ajaxStop(function () {
    $('.ajaxLoading').parent().children().show();
    $('.ajaxLoading').remove();
});

$(document).ready(function () {
    $("a.fancy").fancyZoom();
    if ($('.description .short-task-link').length > 0) {
        addTooltipShortTaskLink($('.description .short-task-link'));
    }
    $(".tooltip-msg").tooltip();

    if ($('.current_language').attr('cur-lang') == 'de') {
        $('.datepicker').datepicker({
            todayHighlight: true,
            language: 'de'
        })
    } else {
        $('.datepicker').datepicker({
            todayHighlight: true
        })
    }
    showLineSeparate();
});

 function showLineSeparate(){
     $('.task').each(function (index, value) {
         if($(this).find(".task-items-closed").length > 0){
             $(this).find(".line-separate-tasks-closed").css("display","block");
         }else{
             $(this).find(".line-separate-tasks-closed").css("display","none");
         }
         if($(this).find(".tasks-status-on-hold .task-item").length > 0){
             $(this).find(".line-separate-tasks-hold").css("display","block");
         }else{
             $(this).find(".line-separate-tasks-hold").css("display","none");
         }
         if($(".overview-task-lists").length > 0) {
             if ($(this).find(".tasks-status-on-hold .task-item").length == 0 && $(this).find(".open-task-items .task-item").length == 0) {
                 $(this).remove();
             }
         }
     });
 }
function addTooltipShortTaskLink(elements) {
    elements.each(function ( ) {
        if (!$(this).attr('data-original-title')) {
            var elem = $(this);
            var taskId = $(this).text().replace('#', '');
            var url = '/show-short-info-task/' + taskId;
            if (taskId) {
                $.ajax({
                    method: "GET",
                    url: url,
                    success: function (data) {
                        if (data) {
                            elem.attr('data-original-title', data.infoTask);
                        }
                    }
                });
            }
        }
        ;
    });
    $(".tooltip-msg").tooltip();
}

if ($('.btn-sort').length > 0) {
    //
    $('.sort-elements').sortable({
        revert: true,
        axis: "y",
        connectWith: '.sort-elements',
        handle: ".btn-sort",
        cursor: "move",
        update: function (event, ui) {
            var order = JSON.stringify($(this).sortable("toArray", {attribute: 'data-id'}));
            var url = $(this).attr('data-sort-url');
            $.post(url, {order: order});
        }
    })
}

$('body').delegate(".input-subscribed-company", "change", function (event) {
    if ($(this).prop('checked')) {
        $('.subscribe-to-email').find('.input-people-subscribed[data-company-id=' + $(this).attr("data-id") + ']').prop('checked', true);
    } else {
        $('.subscribe-to-email').find('.input-people-subscribed[data-company-id=' + $(this).attr("data-id") + ']').prop('checked', false);
    }
});

$('body').delegate(".input-people-subscribed", "change", function () {
    if ($('.input-people-subscribed[data-company-id=' + $(this).attr("data-company-id") + ']')) {
        var companyChecked = true;
        $('.input-people-subscribed[data-company-id=' + $(this).attr("data-company-id") + ']').each(function () {
            if (!$(this).is(":checked")) {
                companyChecked = false;
            }
        });
        if (companyChecked) {
            $('.input-subscribed-company[data-id=' + $(this).attr("data-company-id") + ']').prop("checked", true);
        } else {
            $('.input-subscribed-company[data-id=' + $(this).attr("data-company-id") + ']').prop("checked", false);
        }
    }
});

$('.input-subscribed-company').each(function () {
    var companyChecked = true;
    $('.input-people-subscribed[data-company-id=' + $(this).attr("data-id") + ']').each(function () {
        if (!$(this).is(":checked")) {
            companyChecked = false;
        }
    });
    if (companyChecked) {
        $(this).prop("checked", true);
    } else {
        $(this).prop("checked", false);
    }
});

if ($('.markdown-mini').length) {
    $('.markdown-mini').markdown({
        autofocus: true,
        savable: false,
        hiddenButtons: ['cmdImage', 'cmdCode', 'cmdQuote']
    })
}
$('body').delegate(".change-status-project", "change", function () {
    ajaxSpinnerShow($(this).parent());
    $.get($(this).attr('data-href'), function (data) {

    });
});


$(".time-track-today").hover(function () {
    if (!$('.time-track-today').hasClass('active-track-today')) {
        $.get('/time-track-today', function (data) {
            if (data.timeTrackToday) {
                $('.time-track-today').attr('data-hours', $('.time-track-today span').text());
                $('.time-track-today span').text(data.timeTrackToday);
                $('.time-track-today').addClass('active-track-today');
            }
        });
    }
}, function () {
    $('.time-track-today').removeClass('active-track-today');
    $('.time-track-today span').text($('.time-track-today').attr('data-hours'));
})

$("body").delegate('#wwsc_thalamusbundle_task_responsible, #wwsc_thalamusbundle_task_item_responsible', "change", function (event) {
    $('.responsible-notif').prop('checked', false);
    $('.input-people-subscribed').removeClass('responsible-notif');
    if ($('.input-people-subscribed[value=' + $(this).val() + ']').is(':checked') == false) {
        $('.input-people-subscribed[value=' + $(this).val() + ']').prop('checked', 'checked');
        $('.input-people-subscribed[value=' + $(this).val() + ']').addClass('responsible-notif');
    }
});

$("body").delegate('#date_from_range_filter, #date_to_range_filter', "change", function (event) {
    var aFilterDate = {};
    aFilterDate['date_from'] = $('#date_from_range_filter').val();
    aFilterDate['date_to'] = $('#date_to_range_filter').val();
    changeDateRangeFilter(aFilterDate)
});

$("body").delegate(".clear-date-range", "click", function (event) {
    event.preventDefault();
    var aFilterDate = {};
    aFilterDate['date_from'] = '';
    aFilterDate['date_to'] = '';
    changeDateRangeFilter(aFilterDate)
});

function changeDateRangeFilter(aFilterDate) {
    var url = $('.date_range_filter').attr('data-url');
    $.ajax({
        method: "POST",
        url: url,
        data: {aFilter: aFilterDate},
        success: function (data) {
            location.reload();
        }
    });
}
function printDiv(divId) {
    printDivCSS = new String('<link href="https://' + window.location.hostname + '/bundles/wwscthalamus/css/printOneComment.css" rel="stylesheet" type="text/css">');
    window.frames["print_frame"].document.body.innerHTML = printDivCSS + "<div class='comment-item info-panel col-md-11'>" + document.getElementById(divId).innerHTML + "</div>";
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}