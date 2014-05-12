jQuery(document).ready(function($) {
    $('select').selectpicker();

    $("#archive-browser select").change(function() {

        $(".message").hide();
        $("#archive-content").empty().html("<div style='text-align: center; padding: 30px;'><img src='http://i.imgur.com/TA3o5.gif' /></div>");

        var date = $('#month-choice option:selected').val();
        var dateChunk = date.split("/");
   	var year = dateChunk[3];
        var month = dateChunk[4];
        var cat = $('#cat').val();

        $.ajax({
            url: myajax.ajaxurl,
            type: 'GET',
            data: {
                action: 'load_posts',
		_wpnonce: myajax.custom_nonce,
                cat: cat,
                month: month,
                year: year,
            },
            success: function(data) {
	          if (date == 'no-choice' && cat == "-1") {
                    $("#archive-content").empty().html('<div class="message" align="center">Please choose from above.</div>');
                } else {
                    $("#archive-content").empty().html(data);
                }
            }
        });
        return false;
    });
});
