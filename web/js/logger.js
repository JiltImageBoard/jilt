var fileForm = {
    $container: null,
    $inputs: null,
    fileHashes: {},
    init: function (selector) {
        this.$container = $(selector);
        this.addInput();
    },
    addInput: function () {
        var inputName = "file-" + (this.$container.find('input').length + 1);
        var $input = $('<input type="file" name="' + inputName + '" />').css('display', 'block');
        $input.change(function (e) {
            this.fileChanged($input);
        }.bind(this))
        this.$container.append($input);
    },
    removeInput: function ($input) {
        $input.remove();
        this.$container.find('input').each(function (i, input) {
            $(input).attr('name', 'file-' + (i + 1));
        });
    },
    hasEmptyInputs: function () {
        var result = false;
        this.$container.find('input').each(function (i, input) {
            if (!$(input)[0].files[0]) {
                result = true;
                return false;
            }
        })

        return result;
    },
    fileChanged: function ($input) {
        var file = $input[0].files[0];
        if (file) {
            if (!this.hasEmptyInputs()) {
                this.addInput();
            }
        } else {
            this.removeInput($input);
            delete this.fileHashes[$input.attr('name')];
            return;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            var binary = e.target.result;
            var fileHash = CryptoJS.MD5(CryptoJS.enc.Latin1.parse(binary)).toString();

            $.ajax({
                type: 'get',
                url: '/files/exists/' + fileHash,
                success: function (exists) {
                    if (exists) {
                        this.fileHashes[$input.attr('name')] = fileHash;
                        console.log(this.fileHashes);
                    } else {
                        delete this.fileHashes[$input.attr('name')];
                    }
                }.bind(this),
                error: function (xhr) { console.log(xhr); }
            })
        }.bind(this);

        reader.readAsBinaryString(file);
    }
}

$(function () {
    var $form = $("#testForm");
    var $log = $('#logOutput');

    fileForm.init('#files');

    $form.submit(function (e) {
        e.preventDefault();

        var formData = new FormData($form[0]);

        for (var inputName in fileForm.fileHashes) {
            formData.set(inputName, fileForm.fileHashes[inputName]);
        }

        console.log(data);

        /*$.ajax({
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
                console.log(stringData)
                stringData = stringData.replace(/\\n/g, "<br/>");
                $log.html(stringData);
            }
        });*/

    });
});
