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
    var $log = $('#logArea');

    $('#files').find('input').each(function (i, input) {
        var $input = $(input);
        $input.change(function (e) {
            fileChanged($input);
        });
    });

    // это, думаю, временный вариант, вообще, количество инпутов должно браться из параметров борды, как там
    // оно до этого момента дойдет - хз.

    //var filesCount = $('#files').find('input').size();


    $form.submit(function (e) {
        e.preventDefault();

        var formData = new FormData($form[0]);

        for (var inputName in fileHashes) {
            formData.set(inputName, fileHashes[inputName]);
        }

/*        // текущая реализация такая, что, сервер должен знать сколько файлов ему прочитать
        formData.append('filesCount', filesCount);*/

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                $log.val(JSON.stringify(data));
            },
            error: function (data) {
                $log.val(JSON.stringify(data));
            }
        });

    });
});