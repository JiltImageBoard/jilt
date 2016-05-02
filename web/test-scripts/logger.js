$(function () {
    var fileHashes = {};

    function fileChanged($input) {
        var file = $input[0].files[0];
        if (file) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var binary = e.target.result;
                var fileHash = CryptoJS.MD5(CryptoJS.enc.Latin1.parse(binary)).toString();

                $.ajax({
                    type: 'get',
                    url: '/files/exists/' + fileHash,
                    success: function (exists) {
                        if (exists) {
                            fileHashes[$input.attr('name')] = fileHash;
                        }
                    },
                    error: function (xhr) { console.log(xhr); }
                })
            };

            reader.readAsBinaryString(file);
        } else {
            delete fileHashes[$input.attr('name')];
        }
    }


    var $form = $("#testForm");
    var $log = $('#logOutput');

    $('#files').find('input').each(function (i, input) {
        var $input = $(input);
        $input.change(function (e) {
            fileChanged($input);
        });
    });

    $form.submit(function (e) {
        e.preventDefault();

        var formData = new FormData($form[0]);

        for (var inputName in fileHashes) {
            formData.set(inputName, fileHashes[inputName]);
        }

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                var stringData = JSON.stringify(data)
                stringData = stringData.replace(/\\n/g, "<br/>");
                $log.html(stringData);
            },
            error: function (data) {
                var stringData = JSON.stringify(data)
                stringData = stringData.replace(/\\n/g, "<br/>");
                $log.html(stringData);
            }
        });

    });
});
