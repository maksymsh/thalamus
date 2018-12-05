/* show actions-panel */

var offset=3;

$("body").delegate(".list-task .task .task-box, .list-task .task .task-item .show-task-item", 'mouseenter mouseleave', function (event) {
    if (event.type === 'mouseenter') {
        $(this).find('.actions-panel, .icon-comment-hidden').show();
    } else {
        if(!$(this).find('.actions-panel .ajaxLoading').length){
            $(this).find('.actions-panel, .icon-comment-hidden').hide();
        }
    }
});
/* show form edit task */
$("body").delegate(".btn-edit-task", "click", function (event) {
    event.preventDefault();
    ajaxSpinnerShow($(this).parent());
    var task = $(this).parents('.task');
    var url = $(this).attr('href');
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            task.append(data.htmlTaskForm);
            task.find('.show-task').hide();
            $('.markdown-mini').markdown({
                autofocus:true,
                savable:false,
                hiddenButtons: ['cmdImage','cmdCode','cmdQuote']
            })
        }
    });
});
/* update task */
$("body").delegate(".edit-task .btn-save", "click", function (event) {
    event.preventDefault();
    var task = $(this).parents('.task');
    var formTask = $(this).parents('form');
    ajaxSpinnerShow($(this).parent());
    var values = {};
    $.each(formTask.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    $.ajax({
        type: formTask.attr('method'),
        url: formTask.attr('action'),
        data: values,
        success: function (data) {
            if (data.htmlTask) {
                task.find('.edit-task').remove();
                task.find('.task-info').html(data.htmlTask).parents('.show-task').show();
            }
        }
    });
});

/*delete task */
$("body").delegate(".btn-delete-task", "click", function (event) {
    event.preventDefault();
    var task = $(this).parents('.task');
    if (!confirm("Are you sure you want to delete this to-do list?")) {
        return false;
    };
    ajaxSpinnerShow($(this).parent());
    var url = $(this).attr('href');
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                task.remove();
            }
        }
    });
});
/* hide form edit task*/
$("body").delegate(".edit-task .btn-cancel", "click", function (event) {
    event.preventDefault();
    var task = $(this).parents('.task');
    task.find('.edit-task').remove();
    task.find('.show-task').show();
});


/* sow form add task item*/
$("body").delegate('.btn-add-new-item a', 'click', function (event) {
    event.preventDefault();
    var newItemBox = $(this).parents('.task-item-add');
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            newItemBox.find('.btn-add-new-item').hide().before(data.htmlItemForm);
            if($('#wwsc_thalamusbundle_task_item_type_period_recursion_0').length > 0){
                $('#wwsc_thalamusbundle_task_item_type_period_recursion_0').prop( "checked",true );
                addingNewFieldsRecursiveToTask('wwsc_thalamusbundle_task_item_type_period_recursion_0');
            }
            $('.markdown-mini').markdown({
                autofocus:true,
                savable:false,
                hiddenButtons: ['cmdImage','cmdCode','cmdQuote']
            })
            if($('.current_language').attr('cur-lang') == 'de'){       
                $('.datepicker').datepicker({
                    todayHighlight: true,      
                    language: 'de' });  
            }else{
                $('.datepicker').datepicker({
                    todayHighlight: true
             })};
        }
    });
});
/* hide form edit task item*/
$("body").delegate('.task-item-add  .task-item-form  .btn-cancel', 'click', function (event) {
    event.preventDefault();
    var newItemBox = $(this).parents('.task-item-add');
    newItemBox.find('.task-item-form').remove()
    newItemBox.find('.btn-add-new-item').show();
});

/* created new task item*/
$("body").delegate(".task-item-add .task-item-form form", "submit", function (event) {
    event.preventDefault();
    if($('#wwsc_thalamusbundle_task_item_type_period_recursion_0:checked').length > 0){
        if($('#wwsc_thalamusbundle_task_item_days_weekly_of_recursion input:checked').length == 0){
            alert('Please select days of week');
            return false;
        }
    }
    var taskStatus = $('#wwsc_thalamusbundle_task_item_state').val();
    var task = $(this).parents('.task');
    var formTaskItem = $(this);
    var values = {};
    $.each(formTaskItem.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    $.ajax({
        type: formTaskItem.attr('method'),
        url: formTaskItem.attr('action'),
        data: values,
        success: function (data) {
            if (data.error) {
                task.find('.task-item-form').find('.alert-error').text(data.error);
                return false;
            }
            task.find('.task-item-form').remove()
            if(taskStatus == 'ON_HOLD'){
                task.find('.tasks-status-on-hold').append(data.htmlItem);
            }else{
                if(data.fastTrack == 1){
                    task.find('.open-task-items').prepend(data.htmlItem);
                }else{
                    task.find('.open-task-items').append(data.htmlItem);
                }
            }

            task.find('.btn-add-new-item').show();
        }
    });
});
/* sow form edit task item*/
$("body").delegate(".btn-edit-task-item", "click", function (event) {
    event.preventDefault();
    var taskItem = $(this).parents('.task-item');
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            taskItem.append(data.htmlItemForm);
            taskItem.find('.show-task-item').hide();

            if($('#wwsc_thalamusbundle_task_item_type_period_recursion').length > 0){
                addingNewFieldsRecursiveToTask($('input[name="wwsc_thalamusbundle_task_item[type_period_recursion]"]:checked').attr('id'));
            }
            var taskItemState = taskItem.find('.task-item-state');
            taskItemState.data('old-value', taskItemState.val());
            $('.markdown-mini').markdown({
                autofocus:true,
                savable:false,
                hiddenButtons: ['cmdImage','cmdCode','cmdQuote']
            })

             if($('.current_language').attr('cur-lang') == 'de'){       
                $('.datepicker').datepicker({
                    todayHighlight: true,      
                    language: 'de' });  
            }else{
                $('.datepicker').datepicker({
                todayHighlight: true
            })}


        }
    });
});
/* hide form edit task item*/
$("body").delegate(".task-item .task-item-form .btn-cancel", "click", function (event) {
    event.preventDefault();
    var taskItem = $(this).parents('.task-item');
    taskItem.find('.task-item-form').remove();
    taskItem.find('.show-task-item').show();
});

/* update task item*/
$("body").delegate(".task-item .task-item-form form", "submit", function (event) {
    event.preventDefault();
    if($('#wwsc_thalamusbundle_task_item_type_period_recursion_0:checked').length > 0){
        if($('#wwsc_thalamusbundle_task_item_days_weekly_of_recursion input:checked').length == 0){
            alert('Please select days of week');
            return false;
        }
    }
    var taskItem = $(this).parents('.task-item');
    var formTaskItem = $(this);
    var values = {};
    $.each(formTaskItem.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    $.ajax({
        type: formTaskItem.attr('method'),
        url: formTaskItem.attr('action'),
        data: values,
        success: function (data) {
            if (data.error) {
                taskItem.find('.task-item-form').find('.alert-error').text(data.error);
                return false;
            }
            var taskItemStateSelect = taskItem.find('.task-item-state');
            var taskItemOldState = taskItemStateSelect.data('old-value');
            var taskItemNewState = taskItemStateSelect.val();
            taskItem.find('.task-item-form').remove();
            if(taskItemOldState == taskItemNewState){
                taskItem.replaceWith($(data));
            } else {
                if(taskItemNewState == 'CLOSED'){
                    taskItem.closest('.task').find('.close-task-items').append($(data));
                }else if(taskItemNewState == 'ON_HOLD'){
                    taskItem.closest('.task').find('.tasks-status-on-hold').append($(data));
                }else if(taskItemNewState != 'ON_HOLD' && taskItemOldState == 'ON_HOLD' ){
                    if(taskItem.closest('.task').find('.tasks-status-on-hold .task-item').length < 2){
                        taskItem.closest('.task').find('.tasks-status-on-hold .line-separate-tasks-hold').remove();
                    }
                    taskItem.closest('.task').find('.open-task-items').append($(data));
                }else{
                    taskItem.replaceWith($(data));
                }
                taskItem.remove();
            }
            showLineSeparate()
        }
    });
});
/* change status item */
$("body").delegate(".task-item-status", "click", function (event) {
    var task = $(this).parents('.task');
    var itemTask = $(this).parents('.task-item');
    var itemStatus = $(this).prop('checked');
    var url = $(this).attr('data-url');
    ajaxSpinnerShow($(this).parents('.show-task-item'));
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                if (itemStatus) {
                    itemTask.remove();
                    task.find('.close-task-items').prepend(data);
                } else {
                    itemTask.remove();
                    task.find('.open-task-items').append(data);
                }
                showLineSeparate()
            }
        }
    });
});
/* delete task item */
$("body").delegate(".btn-delete-task-item", "click", function (event) {
    event.preventDefault();
    var taskItem = $(this).parents('.task-item');
    if (!confirm("Are you sure you want to delete this item list?")) {
        return false;
    };
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                taskItem.remove();
                showLineSeparate()
            }
        }
    });
});

$('#form-filter-tasks select').change(function() {
    $('#form-filter-tasks').submit();
});

$("body").delegate("#wwsc_thalamusbundle_task_item_type_period_recursion input", "click", function (event) {
    addingNewFieldsRecursiveToTask($(this).attr('id'));
});

function addingNewFieldsRecursiveToTask(elemId){
    if(elemId == 'wwsc_thalamusbundle_task_item_type_period_recursion_0'){
        $('.select-month-recurring').css('display','none');
        $('.select-days-recurring').css('display','inline-block');
        $('#wwsc_thalamusbundle_task_item_day_of_recursion').prop('required', false);
        $('#wwsc_thalamusbundle_task_item_month_of_recursion').prop('required', false);
        $('#wwsc_thalamusbundle_task_item_day_of_recursion').val('');
        $('#wwsc_thalamusbundle_task_item_month_of_recursion').val('');
    }else{
        $('#wwsc_thalamusbundle_task_item_days_weekly_of_recursion input').prop('checked', false);
        $('.select-month-recurring').css('display','inline-block');
        $('.select-days-recurring').css('display','none');
        $('#wwsc_thalamusbundle_task_item_day_of_recursion').prop('required', true);
        $('#wwsc_thalamusbundle_task_item_month_of_recursion').prop('required', true);
    }
}

$('.list-task .task  .task-item .task-item-more-info .last-update-task').hover(function() {
    $(this).text('Last update was ' + $(this).text());
}, function() {
    $(this).text($(this).text().replace('Last update was ',''));
});
$('body').delegate('.view_next_closed_items','click', function(event){
    var url= $('.close-task-items').attr('data-url-task');
    ajaxSpinnerShow($('.loader-closed-tasks').last(), "big");
    $.ajax({
        url: url + '/' + offset,
        type: 'POST',
        success: function(data){
            if($.trim(data) ==''){
                $('.view_next_closed_items').hide();
            }else{
                $('#show-next-closed-items').append(data);
                offset=parseInt(offset) + 10;
            }
        }});
});

$(document).ready(function(){
   var count = $('.task-items-closed').size();
    if(count>2){
        $('.show_more_closed_task_items').show();
    }

});
