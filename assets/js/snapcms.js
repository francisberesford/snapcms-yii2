$(document).ready(function () {

    // to load ajax lightbox
    $('a.get-ajax').click(function(e) {
        e.preventDefault();
        $.getJSON($(this).attr('href'), function (data) {
            $('div#ajax-area').html(data);
        });
    });
});