var is_loading = false;

$(function () {
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() == $(document).height()) {
            if (is_loading == false) {
                is_loading = true;
                var infiniteScrollBody = $('#infiniteScrollBody');
                var filesCount = $('#files-count');
                var fileSizes = $('#file-sizes');

                var currentPage = infiniteScrollBody.attr('data-current-page');

                ajaxSpinnerShow($('#loader'));

                var nextPage = parseInt(currentPage) + 1;
                var url = infiniteScrollBody.attr('data-url');
                var method = infiniteScrollBody.attr('data-method');
                $.ajax({
                    url: url + '?page=' + nextPage,
                    type: method,
                    success: function (data, status, reqeust) {
                        fileSizes.text(Math.round(parseFloat(fileSizes.text()) + parseFloat(reqeust.getResponseHeader('fileSizes')), 2));

                        filesCount.text(parseInt(filesCount.text()) + 10);
                        infiniteScrollBody.attr('data-current-page', nextPage);

                        infiniteScrollBody.append(data);


                        is_loading = false;
                    }
                });
            }
        }
    });
});