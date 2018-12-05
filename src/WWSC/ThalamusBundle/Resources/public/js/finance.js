/* show actions-panel */

if (window.location.hash) {
    if (window.location.hash.indexOf("cost-id")) {
        var elem = $(window.location.hash).find('.btn-edit-cost');
        showEditCostProject(elem);
    }
}

$("body").delegate(".project-costs tr ", 'mouseenter mouseleave', function (event) {
    if (event.type === 'mouseenter') {
        $(this).find('.actions-panel ').show();
    } else {
        if (!$(this).find('.actions-panel .ajaxLoading').length) {
            $(this).find('.actions-panel').hide();
        }
    }
});

/* show form add cost*/
$("body").delegate('.btn-add-new-cost a', 'click', function (event) {
    event.preventDefault();
    var newFinanceBox = $(this).parents('.add-new-cost');
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            newFinanceBox.find('.btn-add-new-cost').hide().before(data.htmlFinanceForm);
            $(".tooltip-msg").tooltip();
            if ($('.current_language').attr('cur-lang') === 'de') {
                $('.datepicker').datepicker({
                    todayHighlight: true,
                    language: 'de'
                });
            } else {
                $('.datepicker').datepicker({
                    todayHighlight: true
                });
            }
        }
    });
});

$("body").delegate(".finance-add .finance-form", "submit", function (event) {
    event.preventDefault();
    var formFinance = $(this);
    var values = {};
    $.each(formFinance.serializeArray(), function (i, field) {
        if (field.name === 'wwsc_thalamusbundle_finance[invoice_date]' || field.name === 'wwsc_thalamusbundle_finance[due_date]') {
            if ($('.current_language').attr('cur-lang') === 'de') {
                var a = field.value.substring(0, 3);
                var b = field.value.substring(3, 6);
                var c = field.value.substring(6, 10);
                field.value = b + a + c;
            }
        }
        values[field.name] = field.value;
    });
    $.each($('#filter-cost-project').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    ajaxSpinnerShow($(this).find('.btn-save').parent());

    $.ajax({
        type: formFinance.attr('method'),
        url: formFinance.attr('action'),
        data: values,
        success: function (data) {
            if (data.error) {
                formFinance.find('.alert-error').text(data.error);
                return false;
            }
            $('.project-costs').replaceWith(data.htmlFinance);
            $('.finance-header-project').replaceWith(data.headerFinance);
            $('.finance-add').remove();
            $('.btn-add-new-cost').show();
            $(".finance-table tr td.price:contains('-')").addClass('negative');
        }
    });
});

$("body").delegate(".finance-form .btn-cancel", "click", function (event) {
    event.preventDefault();
    if ($(this).parents('.add-new-cost').length > 0) {
        var financeBox = $(this).parents('.add-new-cost');
        financeBox.find('.finance-add').remove();
        financeBox.find('.btn-add-new-cost').show();
    } else {
        $(this).parents('tr').next().show();
        $(this).parents('tr').remove();
    }
});

/* delete task item */
$("body").delegate(".btn-delete-cost", "click", function (event) {
    event.preventDefault();
    var trBoxCost = $(this).parents('tr');
    var idCost = trBoxCost.attr('id');
    if (!confirm("Are you sure you want to delete this cost?")) {
        return false;
    }
    ;
    var values = {};
    $.each($('#filter-cost-project').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "POST",
        url: url,
        data: values,
        success: function (data) {
            if (data) {
                $('#form-' + idCost).remove();
                trBoxCost.remove();
            }
            $('.total-cost-project').text(data.totalAmount);
            $('.finance-header-project').replaceWith(data.headerFinance);
            $(".finance-table tr td.price:contains('-')").addClass('negative');
        }
    });
    return false;
});

$("body").delegate(".btn-copy-cost", "click", function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());

    var values = {};
    $.each($('#filter-cost-project').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    $.ajax({
        type: "POST",
        url: url,
        data: values,
        success: function (data) {
            $('.project-costs').replaceWith(data.htmlFinance);
            $('.finance-header-project').replaceWith(data.headerFinance);
            $(".finance-table tr td.price:contains('-')").addClass('negative');
        }
    });
});

$("body").delegate("#finance-show-closed-projects", "click", function (event) {
    var url = '';
    if ($(this).is(":checked")) {
        url = '/finance?show-closed-projects=true';
    } else {
        url = '/finance';
    }
    window.location.href = url;
});

/* sow form edit task item*/
$("body").delegate(".btn-edit-cost", "click", function (event) {
    event.preventDefault();
});

function showEditCostProject(elem) {
    var trBoxCost = elem.parents('tr');
    var url = elem.attr('href');
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            trBoxCost.before(data.htmlFinanceForm);
            trBoxCost.hide();
            if ($('.current_language').attr('cur-lang') === 'de') {
                $('.datepicker').datepicker({
                    todayHighlight: true,
                    language: 'de'
                });
            } else {
                $('.datepicker').datepicker({
                    todayHighlight: true
                });
            }
        }
    });
}
/* update task item*/
$("body").delegate(".finance-edit form", "submit", function (event) {
    event.preventDefault();
    var costBox = $(this).parents('.finance-edit');
    var formCost = $(this);
    var values = {};
    $.each(formCost.serializeArray(), function (i, field) {
        if (field.name === 'wwsc_thalamusbundle_finance[invoice_date]' || field.name === 'wwsc_thalamusbundle_finance[due_date]') {
            if ($('.current_language').attr('cur-lang') === 'de') {
                var a = field.value.substring(0, 3);
                var b = field.value.substring(3, 6);
                var c = field.value.substring(6, 10);
                field.value = b + a + c;
            }
        }
        values[field.name] = field.value;
    });
    $.each($('#filter-cost-project').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    ajaxSpinnerShow($(this).find('.btn-save').parent());
    $.ajax({
        type: formCost.attr('method'),
        url: formCost.attr('action'),
        data: values,
        success: function (data) {
            if (data.error) {
                costBox.find('.form').find('.alert-error').text(data.error);
                return false;
            }
            $('.project-costs').replaceWith(data.htmlFinance);
            $('.finance-header-project').replaceWith(data.headerFinance);
            $(".finance-table tr td.price:contains('-')").addClass('negative');
        }
    });
});

$("body").delegate("#remove-all-paid-costs", "click", function (event) {
    if ($(this).is(":checked")) {
        var login = '11';
        var password = '22';
        var url = '/finance/export/csv?hide-payd-costs=true' + '&password=' + encodeURIComponent(password);

    } else {
        var url = '/finance/export/csv';
    }
    $('.finance-export a').attr('href', url);
});


$("body").delegate(".project-costs tr", "click", function (event) {
    if ($(this).find('.btn-edit-cost').length > 0 && $('#form-' + $(this).attr('id')).length < 1) {
        ajaxSpinnerShow($(this).find('.btn-edit-cost').parent());
        showEditCostProject($(this).find('.btn-edit-cost'));
    }
    ;
});


$(document).ready(function () {
    if ($('body').hasClass('de')) {
        var replaceFormat = /\./g;
    } else {
        var replaceFormat = /,/g;
    }
    jQuery.tablesorter.addParser({
        id: "fancyNumber",
        is: function (s) {
            return /^[0-9]?[0-9,\.]*$/.test(s);
        },
        format: function (s) {
            return jQuery.tablesorter.formatFloat(s.replace(replaceFormat, ''));
        },
        type: "numeric"
    });
    $('.tablesorter').tablesorter({
        widgets: ['zebra', 'staticRow'],
        headers: {4: {sorter: 'fancyNumber'},
            5: {sorter: 'fancyNumber'},
            6: {sorter: 'fancyNumber'},
            7: {sorter: 'fancyNumber'},
            8: {sorter: 'fancyNumber'},
            9: {sorter: 'fancyNumber'},
            10: {sorter: 'fancyNumber'}
        }
    });
    $('.tablesorter-table-tasks').tablesorter({
        widgets: ['zebra', 'staticRow'],
        // sortList: [[0, 1], [4, 0], [5, 0]],
        headers: {
            0: {sorter: false},
            1: {sorter: 'digit'},
            2: {sorter: false},
            3: {sorter: false},
            4: {sorter: false},
            5: {sorter: false},
            6: {sorter: false}
        }
    });
});
if($('.clip_button').length > 0) {
    var clipboard = new Clipboard('.clip_button', {
        text: function (event) {
            return $(event).attr('data-url');
        }
    });
}