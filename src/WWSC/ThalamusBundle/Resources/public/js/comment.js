/* comment */

let body = $("body");
let textComment = "";

body.delegate(".form-add-comment", "submit", function (event) {
    event.preventDefault();
    $('.btn-save').hide();
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    $(this).find('.btn-save').parent().prepend('<span class="pre-send">Sending... </span>');
    if ($(this).find('.attachment-preview .preview-upload').length > 0) {
        attachmentFiles(this, 'comment');
    } else {
        saveComment($(this), false, true);
    }
});

body.delegate(".attachment-files .cancel", "click", function (event) {
    if (!confirm("Are you sure you want to delete this file?")) {
        return false;
    }
});

body.delegate(".btn-edit-comment", "click", function (event) {
    event.preventDefault();
    let url = $(this).attr('href');
    let commentItem = $(this).parents('.comment-item');
    ajaxSpinnerShow($(this).parents('.comment-info'));
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            commentItem.hide()
            if ($('.form-edit-comment')) {
                $(".comment-item[data-id=" + $('.form-edit-comment').attr('data-id-comment') + "]").show();
                $('.form-edit-comment').remove();
            }
            $('.form-add-comment').hide();
            $('.form-comment').append(data);
            $('.form-comment textarea').markdown({autofocus: true, savable: false})
        }
    });
});

body.delegate(".form-edit-comment", "submit", function (event) {
    event.preventDefault();
    let idComment = $(this).attr('data-id-comment');
    let form = $(this);
    ajaxSpinnerShow(form.find('.btn-save').parent());
    if ($(this).find('.attachment-preview .preview-upload').length > 0) {
        attachmentFiles(this, 'comment', idComment)
    } else {
        saveComment(form, idComment, true);
    }
});

/* delete computer-files files*/
body.delegate(".btn-delete-file", "click", function (event) {
    event.preventDefault();
    let fileItem = $(this).parents('.computer-files');
    if (!confirm("Are you sure you want to delete this file?")) {
        return false;
    }
    let url = $(this).attr('href');
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

body.delegate(".btn-delete-file-attachment", "click", function (event) {
    event.preventDefault();
    let fileItem = $(this).parents('.computer-files');
    let url = $(this).attr('href');
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

body.delegate(".btn-delete-comment", "click", function (event) {
    event.preventDefault();
    let comment = $(this).parents('.comment-item');
    if (!confirm("Are you sure you want to delete comment")) {
        return false;
    }
    let url = $(this).attr('href');
    ajaxSpinnerShow($(this).parents('.comment-info'));
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                comment.remove();
                getReportedHours();
            }
        }
    });
});

body.delegate(".task-item-status", "change", function (event) {
    let taskItemStatus = $(this);
    let url = $(this).attr('data-url');
    let itemStatus = $(this).prop('checked');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                let taskItemWrapper = taskItemStatus.parent().parent();
                if (itemStatus) {
                    taskItemWrapper.addClass('close-item');
                } else {
                    taskItemWrapper.removeClass('close-item');
                }
            }
        }
    });
});

function saveComment(form, idComment, confirmMsg) {

    let values = {};
    $.each(form.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action') + "?confirmMsg=" + confirmMsg,
        data: values,
        success: function (data) {

            if (data.error) {
                form.find('.error').text(data.error);
                return false;
            }

            if (data.confirm != undefined && data.confirm && confirmMsg) {
                if (!confirm(data.message)) {
                    return false;
                } else {
                    saveComment(form, idComment, false);
                }
            }

            if (idComment) {

                let taskItemResponsible = $('.form-edit-comment select[name="wwsc_thalamusbundle_task_item[responsible]"]').val();
                let taskItemState = $('.form-edit-comment select[name="wwsc_thalamusbundle_task_item[state]"]').val();
                form.remove();
                $('.form-add-comment').show();
                $(".comment-item[data-id=" + idComment + "]").replaceWith(data.htmlComment).show();
                if ($('#wwsc_thalamusbundle_task_item_responsible')) {
                    $('#wwsc_thalamusbundle_task_item_state').val(taskItemState);
                    $('#wwsc_thalamusbundle_task_item_responsible').val(taskItemResponsible);
                }
                if (data.notificationSidebar) {
                    $('.comments_notification-sidebar').html(data.notificationSidebar);
                }

            } else {

                textComment = form.find('textarea').val();
                form.find('.error').text('');
                form.find('textarea').val('');
                $('.comments-list').append(data.htmlComment);
                if (data.notificationSidebar) {
                    $('.comments_notification-sidebar').html(data.notificationSidebar);
                }

            }

            addTooltipShortTaskLink($('.description .short-task-link'));

            getReportedHours();

            $("a.fancy").fancyZoom();
            $('.markdown textarea').autogrow();
            $('.attachment-files').find('.gd-file').remove();

            if($('#wwsc_thalamusbundle_comment_time_tracker_time').length > 0) {
                let time = $('#wwsc_thalamusbundle_comment_time_tracker_time').val();
                if (time != 0 && time != '') {
                    if($('.timespan-since-last-time a').length > 0){
                        $('.timespan-since-last-time  a span').text('0:00');
                    }else{
                        $('.timespan-since-last-time').html("<a href=#>Timespan since last time tracking: <span>0:00</span> </a>");
                    }
                }
            }

            $('#wwsc_thalamusbundle_comment_time_tracker_description').val('');
            $('#wwsc_thalamusbundle_comment_time_tracker_time').val('');

            form.find('.attachment-files').unbind();

            let commentsWrapper = $(form).closest('.task-item-comments-wrapper');
            let taskItemTitle = commentsWrapper.find('.comments-title');
            let taskItemStatus = commentsWrapper.find('.task-item-status');

            if ($('#wwsc_thalamusbundle_task_item_state').val() == 'CLOSED') {
                taskItemTitle.addClass('close-item');
                taskItemStatus.prop("checked", true);
            } else {
                taskItemTitle.removeClass('close-item');
                taskItemStatus.prop("checked", false);
            }

            let idStorage = 'coomment_'+$('#wwsc_thalamusbundle_comment_description').data('task-id');
            localStorage.removeItem(idStorage);

            // Hide loading label
            let preSend = $(".pre-send");
            if(preSend.length) {

                // Detach loading label
                preSend.detach();

                // Scroll to added comment
                $('html, body').animate({
                    scrollTop: $("#c_" + data.commentID).offset().top - 100
                }, 500);

            }

        }, error: function () {

            $(".btn-save").hide();
            console.log('We got this error, all ok!');

        }
    });
}

function getReportedHours() {
    if ($('#sumReportedHours').length > 0) {
        $.get($('#sumReportedHours').attr('data-url'), function (data) {
            if(/^[0-9.]+$/.test(data)) {
                $('#sumReportedHours span').text(data);
            }else{
                let idStorage = 'coomment_'+$('#wwsc_thalamusbundle_comment_description').data('task-id');
                if(localStorage.getItem(idStorage) == null){
                    localStorage.setItem(idStorage, textComment);
                }
                alert("Your session has expired. Please login again.");
                location.reload();
            }
        });
        $.get('/user/time-track-today', function (data) {
            if (data.timeTrackToday) {
                $('.time-track-today span').text(data.timeTrackToday);
            }
        });
    }
}

/* relations task*/

body.delegate("#link-show-modal-relations-task", "click", function () {
    let url = $(this).attr('data-url');
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            $('#selected-relations-task').modal('show');
            $('#selected-relations-task .modal-content').html(data.html);
            $('.dropdown-filter').bsDropDownFilter();
        }
    });
});

body.delegate(".relations-task form", "submit", function (event) {
    event.preventDefault();
    let values = {};
    let form = $(this);

    if(form.hasClass('add-new-task') && $('.child-task-input').val().trim() == ''){
        alert("You haven't selected any child task.");
        return false;
    }

    $.each(form.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: values,
        success: function (data) {
            $('.relations-task').replaceWith(data.html);
        }
    });
});

body.delegate(".btn-delete-relation-task", "click", function (event) {
    event.preventDefault();
    let childTask = $(this).parents('.childs-task');
    let url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data.status) {
                childTask.remove();
            }
        }
    });
});

body.delegate('.selected-child-task a ', "change", function (event) {
    let chidTask = $(this).val();
    let url = $('#link-show-modal-relations-task').attr('data-url');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            $('#selected-relations-task .modal-content').html(data.html);
            $('.selected-child-task').val(chidTask);
        }
    });
});

body.delegate('.show-closed-task a', "click", function (event) {
    if ($(this).attr('data-status') == 'hide') {
        $(this).parents('.tasks-select').find('li').removeClass('hidden');
        $(this).text('Hide closed Task');
        $(this).attr('data-status', 'open');
    } else {
        $(this).parents('.tasks-select').find('.closed-task').addClass('hidden');
        $(this).text('Show closed Task');
        $(this).attr('data-status', 'hide');
    }
});

body.delegate('.selected-child-task a.option ', "click", function (event) {
    event.preventDefault();
    if ($(this).parents('form').hasClass('todo_item')) {
        let chidTaskId = $(this).attr('data-value');
        let chidTaskText = $(this).text();
        let url = $('#link-show-modal-relations-task').attr('data-url');
        ajaxSpinnerShow($(this).parent());
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                $('#selected-relations-task .modal-content').html(data.html);
                $('.child-task-input').val(chidTaskId);
                $('.selected-child-task .label-active').text(chidTaskText);
            }
        });
    } else {
        $('.child-task-input').val($(this).attr('data-value'));
        $('.selected-child-task .label-active').text($(this).text());
        $('.selected-child-task .dropdown-menu').css('display', 'none');
    }
});

body.delegate('.create_new_task', "click", function (event) {
    event.preventDefault();
    let url = $('.url-form-add-child').val();
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            $('#selected-relations-task .modal-content').html(data.htmlItemForm);
            $('.dropdown-filter').bsDropDownFilter();

            $('.todo_item .datepicker').datepicker({
                todayHighlight: true
            });
        }
    });
});

body.delegate('.selected-child-task .dropdown-toggle', "click", function (event) {
    if ($('.selected-child-task .dropdown-menu').css('display') == 'block') {
        $('.selected-child-task .dropdown-menu').css('display', 'none');
    } else {
        $('.selected-child-task .dropdown-menu').css('display', 'block');
    }
    return false;
});

body.delegate('.task-list-id', "change", function (event) {
    if ($.trim($(this).val()) != "") {
        let idList = $(this).val();
        let url = $(this).attr('data-responsible-url');
        $.ajax({
            type: "POST",
            data: {id: idList},
            url: url,
            success: function (data) {
                if (data.html) {
                    $('.default-task-item-responsible').hide();
                    $('.select-task-item-responsible').html(data.html);
                }
            }
        });
    } else {
        $('#wwsc_thalamusbundle_task_item_responsible').remove();
        $('.default-task-item-responsible').show();
    }
});

let clipboard = new Clipboard('.clip_button', {
    text: function(event) {
        let preUrl = window.location.href;
        if (preUrl.indexOf('#') > -1) {
            preUrl = preUrl.substr(0, preUrl.indexOf('#'));
        }
        let url = preUrl + '#' + $(event).parents('.comment-item').attr('id');
        return url;
    }
});

body.delegate('.comment-info', "mouseover mouseleave", function (event) {
    if (event.type == "mouseover") {
        $(this).find('.btn-delete-comment').show();
        $(this).find('.btn-link-comment').show();
    } else {
        $(this).find('.btn-delete-comment').hide();
        $(this).find('.btn-link-comment').hide();
    }
});

$(document).ready(function () {
    $('#showCommentBox').change(function () {
        if ($(this).is(":checked")) {
            $('.empty-comment').css('display', 'block');
        } else {
            $('.empty-comment').css('display', 'none');
        }
    });
    let idStorage = 'coomment_'+$('#wwsc_thalamusbundle_comment_description').data('task-id');
    if(localStorage.getItem(idStorage)){
        $('#wwsc_thalamusbundle_comment_description').val(localStorage.getItem(idStorage))
    }
    $("body").delegate("#wwsc_thalamusbundle_comment_description", "keyup", function (event) {
        localStorage.setItem(idStorage, $(this).val());
    });
});


body.delegate(".task-item-comments-wrapper .task-block-comment-header .btn-edit-task-item", "click", function (event) {
    event.preventDefault();
    let taskBlock  =$(this).parents('.task-block-comment-header');
    let taskInfo = $(this).parents('.task-information');
    let url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            let htmlItemForm = data.htmlItemForm;
            taskInfo.addClass("hide");
            htmlItemForm = $(htmlItemForm).find("form").attr("action", $(htmlItemForm).find("form").attr("action") + "?layout=comment").addClass("update-task-info");
            taskBlock.append(htmlItemForm);
        }
    });
});

body.delegate(".task-item-comments-wrapper .task-block-comment-header form.update-task-info", "submit", function (event) {
    event.preventDefault();
    let taskInfo = $(this).parents('.task-block-comment-header').find('.task-information');
    let formTaskItem = $(this);
    let values = {};
    $.each(formTaskItem.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    let isFastTrack = $('#wwsc_thalamusbundle_task_item_fast_track').prop( "checked" );
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    $.ajax({
        type: formTaskItem.attr('method'),
        url: formTaskItem.attr('action'),
        data: values,
        success: function (data) {
            
            if (data.error) {
                taskInfo.find('form').find('.alert-error').text(data.error);
                return false;
            }
            formTaskItem.remove();
            taskInfo.replaceWith($(data));
            if(isFastTrack){
                $('.task-item-comments-wrapper > .panel-heading').css("background-color","hotpink")
            }else{
                $('.task-item-comments-wrapper > .panel-heading').removeAttr("style");
            }

        }, error: function() {

            // Set vars
            let newTitle    = $("#wwsc_thalamusbundle_task_item_description").val();
            let newUserId   = $("#wwsc_thalamusbundle_task_responsible").val();
            let newUserName = $("#wwsc_thalamusbundle_task_responsible :selected").html();
            let newStatus   = $("#wwsc_thalamusbundle_task_item_state :selected").html();

            // Set data
            $(".update-task-info").detach();
            $(".task-information").removeClass("hide");
            $(".responsible").html('<a href="https://thalamus.io/tasks/?filter=1&amp;filter_tasks%5Bfilter_task_status%5D=1&amp;filter_time%5Bfilter_person%5D=u_'+newUserId+'">'+newUserName+'</a>');
            $(".task-item-update-status").html(newStatus);
            $(".task-item-update-title").html(newTitle);

        }
      
    });
});

body.delegate(".task-item-comments-wrapper .task-block-comment-header form .btn-cancel", "click", function (event) {
    event.preventDefault();
    $(this).parents('.task-block-comment-header').find('.task-information').removeClass("hide");
    $(this).parents('form').remove();
});

body.delegate(".timespan-since-last-time a", "click", function (event) {
    event.preventDefault();
    $('#wwsc_thalamusbundle_comment_time_tracker_time').val($(this).find('span').text());
});

if($('.timespan-since-last-time span').length > 0) {
    setInterval(function () {
        let timespan = $('.timespan-since-last-time span').text();
        let currentTime = (new Date(new Date().toDateString() + ' ' + timespan));
        let Time = currentTime.setTime(currentTime.getTime() + 1000 * 60);
        let date = new Date(Time);
        let hours = date.getHours();
        let minutes = "0" + date.getMinutes();
        let newTime = hours + ':' + minutes.substr(-2);
        $('.timespan-since-last-time span').text(newTime)
    }, 60000);
}

function parseHtml()
{
    $('#wwsc_thalamusbundle_comment_description').blur(function () {
        let newText = '';
        let html = $(this).val();
        let parser = $.parseHTML(html);
        $.each(parser, function(i, el){
            if(el.nodeName != '#text'){
                newText += "`<"+el.nodeName.toLowerCase()+">"+el.innerHTML+"</"+el.nodeName.toLowerCase()+">`";
            } else {
                newText += el.textContent;
            }
        });
        $(this).val(newText);
    });

}