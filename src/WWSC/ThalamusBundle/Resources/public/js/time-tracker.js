$('#filters-time-traker select, #filters-time-traker input').change(function() {
    $('#filters-time-traker').submit();
});

$(document).ready(function() {
    if($('.selectpicker').length > 0) {
        $('.selectpicker').selectpicker();
    }
    if($('#calendar').length > 0){
        if($('#calendar').attr('data-editable') == 1){
            var editable = true;
        }else{
            var editable = false;
        }
        $('#calendar').fullCalendar({
            header: {
                left: '',
                center: '',
                right: ''
            },
            events: {
                url: $('#calendar').attr('data-url'),
                cache: true
            },
            defaultDate: $('.datepicker').attr('date-format-js'),
            defaultView: 'agendaDay',
            editable: editable,
            contentHeight: 1055,
            eventResize: function(event, delta, revertFunc) {
                var idTimeTrack = event.id;
                var startTimeTrack = event.start.format();
                var endTimeTrack = event.end.format();
                $.ajax({
                    type: "POST",
                    data: {id: idTimeTrack, startTime: startTimeTrack, endTime: endTimeTrack},
                    url: "/cangePersonalTimetrackingAjax/"+idTimeTrack,
                    success: function (data) {

                    }
                });
            },
            eventDrop: function (event, delta, revertFunc){
                var idTimeTrack = event.id;
                var startTimeTrack = event.start.format();
                var endTimeTrack = event.end.format();
                $.ajax({
                    type: "POST",
                    data: {id: idTimeTrack, startTime: startTimeTrack, endTime: endTimeTrack},
                    url: "/cangePersonalTimetrackingAjax/"+idTimeTrack,
                    success: function (data) {

                    }
                });
            },
            eventMouseover: function(calEvent, jsEvent) {
                var tooltip = '<div class="tooltipevent" style="position:absolute;z-index:10001;">' + calEvent.tooltip + '</div>';
                $("body").append(tooltip);
                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $('.tooltipevent').fadeIn('500');
                    $('.tooltipevent').fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $('.tooltipevent').css('top', e.pageY + 10);
                    $('.tooltipevent').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.tooltipevent').remove();
            }
        });
    }
});
$('body').delegate('#filter_personal_timetracking', 'change', function() {

    var date = $(this).val();
    var user = $('#user-personal-timetracking').val();

    if ($.trim(date)) {
        var url = '/project/all/personal_timetracking?date='+date;
        if(user !== 'undefined'){
            url += '&user='+user;
        }
        location.href = url;
    }
});


/* sow form add task item*/
$("body").delegate('.personal-timetracking .add-manuel-entry', 'click', function (event) {
    event.preventDefault();
    if($('.form-box').length > 0){
        var url =  $('.personal-timetracking').find('.add-manuel-entry').attr('date-url');
        ajaxSpinnerShow($(this).parent());
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                $('.add-manuel-entry').hide();
                $('.personal-timetracking  .form-box').html(data.htmlBox);
            }
        });
    }
});

$("body").delegate(".personal-timetracking .btn-cancel", "click", function (event) {
    event.preventDefault();
    var form = $(this).parents('.form-add-new-entry');
    form.remove();
    $('.add-manuel-entry').show();
});

$('body').delegate('.select-project-personal-timetracking', 'change', function() {
    if ($.trim($(this).val())) {
        var url = '/getTasksProjectForSelect/'+$(this).val();
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                $('.select-tasks-personal-timetracking').replaceWith(data.htmlBox);
                if($('.select-tasks-personal-timetracking').val()){
                    dynamicLoadingTasks($('.select-tasks-personal-timetracking').val());
                }
                if(data.isBillableHours !== undefined){
                    if(data.isBillableHours){
                        $('input[name="personal-timetracking[billable]"]').prop('checked', true);
                    }else{
                        $('input[name="personal-timetracking[billable]"]').prop('checked', false);
                    }
                }
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
});
/* add new personal tracking */
$("body").delegate("#form-add-new-entry", "submit", function (event) {
    event.preventDefault();
    var formTimetracking = $(this);
    ajaxSpinnerShow($(this).parent());
    var values = {};
    $.each(formTimetracking.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    $.ajax({
        type: formTimetracking.attr('method'),
        url: formTimetracking.attr('action'),
        data: values,
        success: function (data) {
            if(data.status == 1){
                $('.form-box').html('');
                $('.box-tracked-hours').html(data.aSumPersonalTrackedHours);
                $('.total-hours-select-day .day_billable_hours').text(data.aTotalHours.total_billable_hours);
                $('.total-hours-select-day .day_non_billable_hours').text(data.aTotalHours.total_non_billable_hours);
                $('.add-manuel-entry').show();
                $('#calendar').fullCalendar( 'refetchEvents' );

            }
            else{
                if(formTimetracking.find('.error').length < 1){
                    formTimetracking.prepend( '<div class="col-md-12 error">Inccorect data</div>');
                }
            }
        }
    });
});


/* update personal tracking */
$("body").delegate("#form-edit-entry", "submit", function (event) {
    event.preventDefault();
    var formTimetracking = $(this);
    ajaxSpinnerShow($(this).parent());
    var values = {};
    $.each(formTimetracking.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    $.ajax({
        type: formTimetracking.attr('method'),
        url: formTimetracking.attr('action'),
        data: values,
        success: function (data) {
            if(data.status == 1){
                $('.form-box').html('');
                $('.add-manuel-entry').show();
                $('.total-hours-select-day .day_billable_hours').text(data.aTotalHours.total_billable_hours);
                $('.total-hours-select-day .day_non_billable_hours').text(data.aTotalHours.total_non_billable_hours);
                $('.box-tracked-hours').html(data.aSumPersonalTrackedHours);
                $('#calendar').fullCalendar( 'refetchEvents' );
            }
            else{
                if(formTimetracking.find('.error').length < 1){
                    formTimetracking.prepend( '<div class="col-md-12 error">Inccorect data</div>');
                }
            }
        }
    });
});

$("body").delegate('#user-personal-timetracking', 'change', function (event) {
    event.preventDefault();

    var date = $('#filter_personal_timetracking').val();
    var user = $(this).val();

    var url = '/project/all/personal_timetracking?date='+date+'&user='+user;

    location.href = url;
});

$("body").delegate('.select-tasks-personal-timetracking', 'change', function (event) {
    event.preventDefault();
    dynamicLoadingTasks($(this).val());
});

function dynamicLoadingTasks(id){
    var url = '/personal-timetracking/user-for-select?task='+id;
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if(data.htmlBox){
                $('.select-user-personal-timetracking').replaceWith(data.htmlBox)
            }
        }
    });
}

$("body").delegate(".fc-time-grid-event", "click", function (event) {
    event.preventDefault();
    if($('.form-box').length > 0){
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                $('.add-manuel-entry').hide();
                $('.personal-timetracking  .form-box').html(data.htmlBox)
            }
        });
    }
});
