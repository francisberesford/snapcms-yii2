$(document).ready(function () {

    // to load ajax lightbox
    $(document).on('click', 'a.get-ajax', function(e) {
        e.preventDefault();
        $.getJSON($(this).attr('href'), function (data) {
            $('div#ajax-area').html(data);
        });
    });
});