/**
 * Created by mykolat on 11/3/2015.
 */
var is_loading = false;

$(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            if (is_loading == false) {
                is_loading = true;
                var currentPage = $('.log-table-box').attr('data-current-page');
                ajaxSpinnerShow($('#loader'));
                var nextPage = parseInt(currentPage) + 1;
                var url = $('.log-table-box').attr('data-url');
                $.ajax({
                    url: url+'/'+nextPage,
                    type: 'POST',
                    success:function(data){
                        $('.log-table-box').attr('data-current-page',nextPage);
                        $('#items').append(data);
                        $('.overview-today').each(function()
                        {
                           if( $('.overview-today[data-day-log="'+$(this).attr('data-day-log')+'"]').length > 1){
                               $('.overview-today[data-day-log="'+$(this).attr('data-day-log')+'"]' ).last().remove();
                             }
                        });
                          is_loading = false;
                    }
                });
            }
        }
    });
});