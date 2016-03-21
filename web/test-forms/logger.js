
$(function() {
    var $form = $("#testForm");
    $form.submit(function(e) {

        e.preventDefault();

        var actionurl = e.currentTarget.action;
        var $logArena = $('#logArea');

        $.ajax({
            url: actionurl,
            type: $form.attr('method'),
            dataType: 'json',
            data: $("#testForm").serialize(),
            success: function(data) {
                $logArena.val('');
                $logArena.val(JSON.stringify(data));
            },
            error: function(data){
                $logArena.val('');
                $logArena.val(JSON.stringify(data));
            }
        });

    });

});